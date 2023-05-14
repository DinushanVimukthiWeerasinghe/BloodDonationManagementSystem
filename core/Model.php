<?php
namespace Core;
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_NUMERIC = 'num';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_UNIQUE = 'uniq';
    public const RULE_MATCH = 'match';
    public const RULE_OLDER_DATE = 'older_date';
    public const RULE_TODAY_OR_OLDER_DATE = 'today_or_older_date';
    public const RULE_UPCOMING_DATE = 'upcoming_date';
    public const RULE_MAX_VALUE = 'max_value';
    public const RULE_MIN_VALUE = 'min_value';

    public const RULE_MOBILE_NO = 'mobile';
    abstract public function labels():array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

    }

    public function getFile($file='file'): File
    {
        return new File($_FILES[$file]);
    }

    abstract public function rules():array;
    public array $errors = [];




    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
    public function validate($update=false): bool
    {

        foreach ($this->rules() as $attribute=>$rules)
        {

            $value=$this->{$attribute};
            foreach ($rules as $rule)
            {

                $rulename=$rule;

                if(!is_string($rulename)){
                    $rulename=$rule[0];
                }

                if($rulename===self::RULE_REQUIRED && empty($value))
                {

                    $this->addErrorRule($attribute, self::RULE_REQUIRED,['field'=>$this->getLabel($attribute)]);
                }
                if($rulename===self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorRule($attribute, self::RULE_EMAIL);
                }
                if($rulename===self::RULE_MIN && mb_strlen($value)<$rule['min'])
                {
                    $this->addErrorRule($attribute, self::RULE_MIN,['min'=>$rule['min'],'field'=>$this->getLabel($attribute)]);
                }
                if($rulename===self::RULE_MAX && mb_strlen($value)>$rule['max'])
                {
                    $this->addErrorRule($attribute, self::RULE_MAX,['max'=>$rule['max'],'field'=>$this->getLabel($attribute)]);
                }
                if ($rulename===self::RULE_NUMERIC && !is_numeric($value))
                {
                    $this->addErrorRule($attribute, self::RULE_NUMERIC);
                }if ($rulename===self::RULE_MOBILE_NO && !preg_match('/^(?:0|94|\+94|0094)?(?:(11|21|23|24|25|26|27|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|63|65|66|67|81|91)([0234579])|7([01245678])\d)\d{6}$/', $value))
                {
                    $this->addErrorRule($attribute, self::RULE_MOBILE_NO);
                }
                if ($rulename===self::RULE_TODAY_OR_OLDER_DATE && strtotime($value) > strtotime(date('Y-m-d') . ' +1 day'))
                {
                    $this->addErrorRule($attribute, self::RULE_TODAY_OR_OLDER_DATE,['field'=>$this->getLabel($attribute)]);
                }
                if ($rulename===self::RULE_OLDER_DATE && strtotime($value) > strtotime(date('Y-m-d')))
                {
                    $this->addErrorRule($attribute, self::RULE_OLDER_DATE,['field'=>$this->getLabel($attribute)]);
                }
                if ($rulename===self::RULE_UPCOMING_DATE && strtotime($value) < strtotime(date('Y-m-d')))
                {
                    $this->addErrorRule($attribute, self::RULE_UPCOMING_DATE,['field'=>$this->getLabel($attribute)]);
                }
                if ($rulename===self::RULE_MAX_VALUE && $value > $rule['max'])
                {
                    $this->addErrorRule($attribute, self::RULE_MAX_VALUE,['max'=>$rule['max'],'field'=>$this->getLabel($attribute)]);
                }
                if ($rulename===self::RULE_MIN_VALUE && $value < $rule['min'])
                {
                    $this->addErrorRule($attribute, self::RULE_MIN_VALUE,['min'=>$rule['min'],'field'=>$this->getLabel($attribute)]);
                }
                if(!$update && $rulename===self::RULE_UNIQUE)
                {
                    //Get Class Name
                    $className=get_class($this);
                    $uniqueAttr=$rule['attribute'] ?? $attribute;
                    $tableName=$className::tableName();
                    $sql="SELECT * FROM $tableName WHERE $uniqueAttr=:attr";
                    $statement=Application::$app->db->prepare($sql);
                    $statement->bindValue(':attr',$value);
                    $statement->execute();
                    $record=$statement->fetchObject();
                    if($record){
                        $this->addErrorRule($attribute,self::RULE_UNIQUE,['field'=>$this->getLabel($attribute)]);
                    }
                }
                if($rulename===self::RULE_MATCH && $value!=$this->{$rule['match']})
                {
                    $rule['match']=$this->getLabel($rule['match']);
                    $this->addErrorRule($attribute, self::RULE_MATCH,$rule);
                }
            }

        }
        return empty($this->errors);
    }
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][]=$message;
    }

    private function addErrorRule(string $attribute, string $rule, $params=[]): void
    {
        $message=$this->errorMessages()[$rule] ?? '';
        foreach ($params as $key=>$value)
        {
            $message=str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][]=$message;
    }
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED=>'{field} is required',
            self::RULE_EMAIL=>'Enter a valid email',
            self::RULE_MIN=>'This {field} must be at least {min} characters long',
            self::RULE_MAX=>'This {field} must be at most {max} characters long',
            self::RULE_MATCH=>'This {field} must same as {match}',
            self::RULE_UNIQUE=>'This {field} already exist',
            self::RULE_NUMERIC=>'This {field} must be numeric',
            self::RULE_MOBILE_NO=>'This {field} must be a valid mobile number',
            self::RULE_OLDER_DATE=>'This {field} must be older than today',
            self::RULE_UPCOMING_DATE=>'This {field} must be upcoming date',
            self::RULE_TODAY_OR_OLDER_DATE=>'This {field} must be today or older than today',
            self::RULE_MAX_VALUE=>'This {field} must be less than {max}',
            self::RULE_MIN_VALUE=>'This {field} must be greater than {min}',
        ];

    }

}