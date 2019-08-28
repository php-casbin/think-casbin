<?php

namespace CasbinAdapter\Think;

use CasbinAdapter\Think\Models\CasbinRule;
use Casbin\Persist\Adapter as AdapterContract;
use Casbin\Persist\AdapterHelper;

/**
 * DatabaseAdapter.
 *
 * @author techlee@qq.com
 */
class Adapter implements AdapterContract
{
    use AdapterHelper;

    protected $casbinRule;

    public function __construct(CasbinRule $casbinRule)
    {
        $this->casbinRule = $casbinRule;
    }

    public function savePolicyLine($ptype, array $rule)
    {
        $col['ptype'] = $ptype;
        foreach ($rule as $key => $value) {
            $col['v'.strval($key).''] = $value;
        }
        $this->casbinRule->create($col);
    }

    public function loadPolicy($model)
    {
        $rows = $this->casbinRule->select()->toArray();

        foreach ($rows as $row) {
            $line = implode(', ', array_filter(array_slice($row, 1), function ($val) {
                return '' != $val && !is_null($val);
            }));
            $this->loadPolicyLine(trim($line), $model);
        }
    }

    public function savePolicy($model)
    {
        foreach ($model->model['p'] as $ptype => $ast) {
            foreach ($ast->policy as $rule) {
                $this->savePolicyLine($ptype, $rule);
            }
        }

        foreach ($model->model['g'] as $ptype => $ast) {
            foreach ($ast->policy as $rule) {
                $this->savePolicyLine($ptype, $rule);
            }
        }

        return true;
    }

    public function addPolicy($sec, $ptype, $rule)
    {
        return $this->savePolicyLine($ptype, $rule);
    }

    public function removePolicy($sec, $ptype, $rule)
    {
        $result = $this->casbinRule->where('ptype', $ptype);

        foreach ($rule as $key => $value) {
            $result->where('v'.strval($key), $value);
        }

        return $result->delete();
    }

    public function removeFilteredPolicy($sec, $ptype, $fieldIndex, ...$fieldValues)
    {
        $count = 0;

        $instance = $this->casbinRule->where('ptype', $ptype);
        foreach (range(0, 5) as $value) {
            if ($fieldIndex <= $value && $value < $fieldIndex + count($fieldValues)) {
                if ('' != $fieldValues[$value - $fieldIndex]) {
                    $instance->where('v'.strval($value), $fieldValues[$value - $fieldIndex]);
                }
            }
        }

        foreach ($instance->select() as $model) {
            if ($model->delete()) {
                ++$count;
            }
        }

        return $count;
    }
}
