<?php

namespace App\model\database;

use App\model\users\User;
use Core\Application;
use Core\Model;
use PDO;
use PDOException;

abstract class dbModel extends Model
{

    abstract public static function getTableShort():string;
    abstract public static function tableName(): string;
    abstract public static function PrimaryKey(): string;
    abstract public function attributes(): array;
//    abstract public function relations(): array;
    private string $WherePrimaryKey='';

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function generateID($param="")
    {
        return uniqid($param);
    }

//    abstract public function getPrimaryKey(): string;
    /**
     * @param string $id
     */

    /**
     * @return string
     */
    public function getWherePrimaryKey(): string
    {
        return $this->WherePrimaryKey;
    }

    /**
     * @param string $PrimaryKey
     */
    public function setWherePrimaryKey(string $PrimaryKey): void
    {
        $this->WherePrimaryKey = $PrimaryKey;
    }
    public function toArray(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    public static function InnerJoinRetrieveAll(string $JoinTableName,string $inner_ID = 'ID')
    {
        $tableName = static::tableName();
        $primaryKey = static::PrimaryKey();
        $statement = self::prepare("SELECT * FROM $tableName Inner Join $JoinTableName on $tableName.$primaryKey=$JoinTableName.$inner_ID");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,static::class);

    }

    public static function getCount(bool $like=false,array $condition=[]): int
    {
        $tableName = static::tableName();
        if (!empty($condition)) {
            $attributes = array_keys($condition);
            if ($like){
                $sql= implode(" OR ",array_map(fn($attr)=>"$attr LIKE :$attr",$attributes));
                $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
                foreach ($condition as $key => $value) {
                    $statement->bindValue(":$key","%".$value."%");
                }
                $statement->execute();
                return $statement->rowCount();
            }
            $attributes = array_keys($condition);
            $sql= implode("AND ",array_map(fn($attr)=>"$attr = :$attr",$attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($condition as $key => $value) {
                $statement->bindValue(":$key",$value);
            }
            $statement->execute();
            return $statement->rowCount();
        }else{
            $statement = self::prepare("SELECT * FROM $tableName");
            $statement->execute();
            return $statement->rowCount();
        }


    }

    public static function Search(array $array,array $exactMatch=[],array $limit=[]): bool|array
    {
        $tableName = static::tableName();
        $primaryKey = static::PrimaryKey();
        $attributes = array_keys($array);
        $sql= implode(" OR ",array_map(fn($attr)=>"$attr LIKE :$attr",$attributes));
        $exactMatchSql='';
        if (!empty($exactMatch)){
            $exactMatchKeys = array_keys($exactMatch);
            $exactMatchSql = implode(" OR ",array_map(fn($attr)=>"$attr = :$attr",$exactMatchKeys));
        }

        $limits='';
        if (!empty($limit)){
            $limits=" LIMIT $limit[0],$limit[1]";
        }
        if (!empty($exactMatchSql)){
            $sql="(".$sql.") AND "."(".$exactMatchSql.")";
        }
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql $limits");
        foreach ($array as $key => $value) {
            $statement->bindValue(":$key","%".$value."%");
        }
        foreach ($exactMatch as $key => $value) {
            $statement->bindValue(":$key",$value);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,static::class);
    }


    public static function RetrieveAll(bool $pagination=false,array $limit=[],bool $IsConditional=false,array $conditions=[],array $OrderBy=[],array $GroupBy=[]): bool|array
    {
        $tableName = static::tableName();
        $sql = "SELECT * FROM $tableName";
        if ($IsConditional) {
            $sql = "SELECT * FROM $tableName WHERE ";
            $attributes = array_keys($conditions);
            foreach ($conditions as $key => $value) {
                if (is_array($value)){
                    $check = $value[0].' "'.$value[1].'"';
                    $sql .=$key. ' ' .$check.' AND ';
//                    $sql .= "$key $check AND ";

                    $attributes = array_filter($attributes, fn($attr) => $attr !== $key);
                }
//                Delete from $attributes where $key = $value
            }

            $sql .= implode(' AND ', array_map(fn($attr) => "$attr = :$attr", $attributes));
            if ($OrderBy){
                $sql.=" ORDER BY ";
                foreach ($OrderBy as $key => $value) {
                    $sql.="$key $value,";
                }
                $sql=substr($sql,0,-1);
            }
            if ($pagination) {
                $sql .= " LIMIT $limit[0],$limit[1]";
            }
            $statement = self::prepare($sql);
            foreach ($conditions as $key => $value) {
                if (!is_array($value)){
                    $statement->bindValue(":$key",$value);
                }
            }
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS,static::class);
        } else {
            if ($OrderBy){
                $sql.=" ORDER BY ";
                foreach ($OrderBy as $key => $value) {
                    $sql.="$key $value,";
                }
                $sql=substr($sql,0,-1);
            }
            if ($pagination) {
                $sql .= " LIMIT $limit[0],$limit[1]";
            }

            $statement = self::prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS,static::class);
        }

    }



    private function saveRealtion(string $table1,string $table2){
        return $table1.'_'.$table2;
    }
    private function countDigits($MyNum){
        $MyNum = (int)$MyNum;
        $count = 0;

        while($MyNum != 0){
            $MyNum = (int)($MyNum / 10);
            $count++;
        }
        return $count;
    }


    private function getPrimaryKey($table){
        $sql = "SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY'";
        $gp = self::prepare($sql);
        $gp->execute();
        $cgp = $gp->rowCount();
        $PK=[];
        if ($cgp > 0) {
            // Note I'm not using a while loop because I never use more than one prim key column
            $result = $gp->fetchAll();
            foreach ($result as $key => $value) {
                $PK[] = $value['Column_name'];
            }
            return($PK);
        } else {
            return(false);
        }
    }

    public function getIndex($number)
    {
        if($this->countDigits($number)==1){
            return '00'.$number;
        }
        elseif ($this->countDigits($number)==2){
            return '0'.$number;
        }
        else{
            return $number;
        }
    }

    public function save(array $Exclude=[])
    {

        $tableName = static::tableName();
        $attributes = $this->attributes();
        $PK = $this->getPrimaryKey(static::tableName())[0];
        $params = array_map(fn($attr) => ":$attr", $attributes);

        foreach ($Exclude as $key => $value) {
            $index = array_search(":$value", $params);
            unset($attributes[$index]);
            unset($params[$index]);
        }
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
//        $attributes['username']="username";
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        try {
            $statement->execute();
            return true;

        }catch (PDOException $e){
            return false;
        }



    }

    public function delete(array $where=[])
    {
        $tableName = static::tableName();
        if (!empty($where)){
            $attributes = array_keys($where);
            $sql= implode(" AND ",array_map(fn($attr)=>"$attr = :$attr",$attributes));
            $statement = self::prepare("DELETE FROM $tableName WHERE $sql");
            foreach ($where as $key => $value) {
                $statement->bindValue(":$key",$value);
            }
            $statement->execute();
            return $statement->rowCount();
        }else{
            $primaryKey = static::PrimaryKey();
            $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = :$primaryKey");
            $statement->bindValue(":$primaryKey", $this->{$primaryKey});
            var_dump($statement);
            $statement->execute();
            return $statement->rowCount();
        }
    }


    public function update($id, $Exclude = [],$Include=[],$where=[]): bool
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $demo = 'UPDATE ' . $tableName . ' SET ';
        if (!empty($Include)){
            foreach ($attributes as $attribute) {
                if ($attribute == static::PrimaryKey()) {
                    continue;
                }

                if (in_array($attribute, $Include)) {

                    $demo .= $attribute . '="' . $this->{$attribute} . '", ';
                }
            }


        }else {
            foreach ($attributes as $attribute) {
                if ($attribute == static::PrimaryKey()) {
                    continue;
                }
                if (in_array($attribute, $Exclude)) {
                    continue;
                }
                $demo .= $attribute . '="' . $this->{$attribute} . '", ';
            }
        }
        $demo=substr($demo,0,-2);
        $demo.=' WHERE '.static::PrimaryKey().'="'.$id.'"';
        if (!empty($where)){
            $demo.=' AND ';
            foreach ($where as $key=>$item){
                $demo.=$key.'="'.$item.'" AND ';
            }
            $demo=substr($demo,0,-4);
        }



        $statement=self::prepare($demo);

        $statement->execute();
        return true;
    }


    public static function InnerJoinFindOne(string $JoinTableName,array $where,string $inner_ID = 'ID')
    {
        $tableName = static::tableName();
        $primaryKey = static::PrimaryKey();
        $attributes=array_keys($where);
        $cond=implode(" AND ",array_map(fn($attr)=>"$attr=:$attr",$attributes));

        $statement = self::prepare("SELECT * FROM $tableName Inner Join $JoinTableName on $tableName.$primaryKey=$JoinTableName.$inner_ID where $cond" );
        foreach ($where as $key=>$item)
        {
            $statement->bindValue(":$key",$item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);

    }
    public static function updateOne(array $where, array $value)
    {
        $tableName= static::tableName();
        $attributes=array_keys($where);
        $update_values=array_keys($value);

        $sql=implode(" AND ",array_map(fn($attr)=>"$attr=:$attr",$attributes));
        $val=implode(",",array_map(fn($attr)=>"$attr=:$attr",$update_values));

        $statement=self::prepare("UPDATE $tableName SET $val WHERE $sql");
        foreach ($where as $key=>$item)
        {
            $statement->bindValue(":$key",$item);
        }
        foreach ($value as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
    }




    public static function findOne($where, $OR = true)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        if ($OR) {
            $sql = implode(" OR ", array_map(fn($attr) => "$attr=:$attr", $attributes));
        } else {
            $sql = implode(" AND ", array_map(fn($attr) => "$attr=:$attr", $attributes));
        }

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
    }
    public static function DeleteOne($where)
    {
        $tableName= static::tableName();
        $attributes=array_keys($where);
        $sql=implode(" AND ",array_map(fn($attr)=>"$attr=:$attr",$attributes));
        $statement=self::prepare("DELETE FROM $tableName WHERE $sql");
//        print_r($statement);
//        print_r($where);
//        exit();
        foreach ($where as $key=>$item)
        {
            $statement->bindValue(":$key",$item);
        }
        return $statement->execute();

    }
    public static function prepare($sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    private function getColoumnName(string $table)
    {
        $sql="SHOW columns FROM ".$table;
        $statement=self::prepare($sql);
        $statement->execute();
        $result=$statement->fetchAll();
        $columns=[];
        foreach ($result as $item)
        {
            $columns[]=$item['Field'];
        }
        return $columns;
    }


}