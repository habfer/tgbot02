<?php

class GeneratePasswords
{

    protected $chars = "qazxswedcvfrtgbnhyujmkiolp!@$%^&*()_+=-[]{}';:/\|`~1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
    
    public function GeneratePassword($choice)
    {
        $size = StrLen($this->chars) - 1;

        $password = null;

        switch ($choice) {
            case "easy":
                $max = 8;
                break;
            case "medium":
                $max = 12;
                break;
            case "hard":
                $max = 16;
                break;
            default:
                return "Choose one of 3 difficulties, please.";
                break;
        }

        while ($max--) 
            $password .= $this->chars[rand(0, $size)]; 

        return $password;
    }

}