<?php

namespace App\view\components\ResponsiveComponent\FormComponent;

use App\model\database\dbModel;
use Core\Application;
use Core\Model;

class BasicForm
{

    const SUBMIT_BUTTON = 'submit';
    const RESET_BUTTON = 'reset';
    const REGULAR_BUTTON = 'button';
    protected static Model $model;
    public static function GetCss(): string
    {
        return <<<HTML
            <link href="/public/css/components/form/index.css" rel="stylesheet">
        HTML;
    }
    public static function GetJS(): string
    {
        return <<<HTML
            <script src="/public/js/components/form/index.js">
        HTML;
    }

    public static function CheckError(dbModel $model)
    {
        if (!empty($model->errors)){
            $error = '';
            foreach ($model->errors as $key => $value) {
                $error .= $value[0] ;
                break;
            }
            return <<<HTML
                <script>
                SweetAlert.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '$error',
                })
</script>
HTML;

        }
    }

    public static function CreateForm(Model $model,string $image="j"): string
    {
        $img='';
        if (empty($img))
        {
//            $img.='<div class="profile-image"><img src="/public/images/contact-us.png" alt="" width="200px"></div>';
        }
        static::$model= $model;
        $css=static::GetCss();
        return <<<HTML
            {$css}
            <div class="outer-form">
                {$img}
                <form action="" method="post" enctype="multipart/form-data">
        HTML;
    }

    public static function CreateRow(): string
    {
        return <<<HTML
            <div class="form-row">
        HTML;
    }

    public static function HiddenErrorLabel($error):string
    {
        if (trim($error) == '') {
            return 'hidden';
        }else{
            return '' ;
        }

    }

    public static function CreateTextInput($attribute): string
    {
        $model=static::$model;
        $labelFor=strtolower($model->getLabel($attribute));
        $value=$model->GetAttributesValue($attribute) ?? '';
        $error=$model->getFirstError($attribute) ?? '';
//        $Hidden=static::HiddenErrorLabel($model->getFirstError($attribute));
        return <<<HTML
            <div class="form-entity">
                <div class="valid">
                    <label for="{$labelFor}" class="form-label">{$model->getLabel($attribute)}</label>
                    <input id="{$labelFor}" class="form-input" required type="text" name="{$attribute}" value="{$value}" oninvalid="this.setCustomValidity('Enter {$model->getLabel($attribute)} Name Here')" oninput="this.setCustomValidity('')" >
                    <span class="error-text">{$error}</span>
                </div>
            </div>
        HTML;
    }

    public static function EndingRow(): string
    {
        return <<<HTML
            </div>
        HTML;
    }

    public static function CreateSelectInput($attribute,$option): string
    {
        $model=static::$model;
        $labelFor=strtolower($model->getLabel($attribute));
        $value=$model->GetAttributesValue($attribute) ?? '';
        $options='';
        if (empty($value)){
            $options.='<option value="" selected disabled hidden>Select Position</option>';
        }
        foreach ($option as $key=>$value){
            if ($value==$model->GetAttributesValue($attribute)){
                $options.="<option value='{$value}' selected>{$value}</option>";
            }else {
                $options .= <<<HTML
                <option value="{$value}">{$value}</option>
                HTML;
            }
        }

        return <<<HTML
            <div class="form-entity">
                <div class="valid">
                    <label for="{$labelFor}" class="form-label">{$model->getLabel($attribute)}</label>
                    <select id="{$labelFor}" class="form-select " name='{$attribute}'>
                    {$options}
                    </select>
                </div>
            </div>
        HTML;
    }

    public static function CloseForm(): string
    {
        return <<<HTML
                </form>
            </div>
        HTML;

    }

    public static function CreateImage($alt=''): string
    {
        $url=static::$model->GetAttributesValue('ImageURL');
        $width='100px';
        return <<<HTML
            <div class="form-entity">
                <img class="image" src="{$url}" alt="$alt" width="{$width}">
            </div>
        HTML;
    }

    public static function CreateFileInput(string $attribute,string $pickerText=''): string
    {
        $model=static::$model;
        $labelFor=strtolower($model->getLabel($attribute));
        $value=Application::$ROOT_DIR.'/public/images/campaign.png';
        return <<<HTML
            <div class="form-entity">
                <label for="{$labelFor}" class="file-label">
                    <input id="{$labelFor}" type="file" class="form-input " onchange="PreviewImage(this)" accept="image/*" name="image" id="image" value="{$value}">
                </label>
            </div>
        HTML;


    }

    public static function CreateDateInput(string $attribute): string
    {
        $model=static::$model;
        $labelFor=strtolower($model->getLabel($attribute));
        $value=$model->GetAttributesValue($attribute) ?? '';
        return <<<HTML
            <div class="form-entity">
                  <div class="valid">
                    <label for="{$labelFor}" class="form-label">{$model->getLabel($attribute)}</label>
                    <input id="{$labelFor}" class="form-input select-date" required type="date" name="{$attribute}" value={$value} >
                   </div>
            </div>
        HTML;
    }

    public static function FormButton($type,$value,$id=''): string
    {
        if ($type==static::REGULAR_BUTTON){
            return <<<HTML
                <button type="submit" class="btn button" onclick="Delete(id)">{$value}</button>
            HTML;
        }elseif ($type==static::RESET_BUTTON || $type==static::SUBMIT_BUTTON) {
            return <<<HTML
            <div class="form-entity">
                <input class="btn submit" type="{$type}" value="{$value}" >
            </div>
        HTML;
        }
    }
}