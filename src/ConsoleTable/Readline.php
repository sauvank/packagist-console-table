<?php

namespace ConsoleTable;


class Readline{

    private $answer = "";

    public function __construct(?string $txt, array $availableParams = [], int $defaultValueIndex = -1)
    {
        if($txt === null){
            return $this;
        }

        if($defaultValueIndex >= 0 && $defaultValueIndex > count($availableParams)){
            throw new \Exception("invalid defaultValueIndex params !\n");
            return;
        }

        $this->choices($txt, $availableParams, $defaultValueIndex);
        return $this;
    }

    private function choices(string $txt, array $availableParams, int $defaultValueIndex){
        $activeParams = count($availableParams) > 0;

        // Upper default value params if is active.
        if($activeParams && $defaultValueIndex >= 0){
            $availableParams[$defaultValueIndex] = strtoupper(ucfirst($availableParams[$defaultValueIndex]));
        }

        $txt = $activeParams ? $txt .= " (". implode('/', $availableParams) . ")" : $txt;

        echo $txt .= "\n";
        $this->answer = readline("> ");

        if($activeParams){
            if(strlen($this->answer) === 0 && $defaultValueIndex >= 0){
                $this->answer = $availableParams[$defaultValueIndex];
            }elseif (array_search(strtolower($this->answer),  array_map('strtolower', $availableParams)) === false){
                $result = new Readline("The answer $this->answer is invalid, please enter valid value", $availableParams, $defaultValueIndex);
                $this->answer = $result->getAnswer();
            }
        }
    }

    public function getAnswer(){
        return $this->answer;
    }

    /**
     * Show confirm message to CLI
     * @param string $msg message to show, by default : Do you want to confirm your choice ?
     * @param array|string[] $option list of options available by default [y,n]
     * @param int $defaultIndexValue index of the array of the default value (if the user validates without giving an answer). default 1
     * @param int $indexConfirmOption Index of the $option value that corresponds to the validation
     * @return bool
     * @throws \Exception
     */
    public function confirm(string $msg = 'Do you want to confirm your choice ?', array $option = ['y', 'n'], $defaultIndexValue = 1, $indexConfirmOption = 0) :bool {

        if(!isset($option[$indexConfirmOption])){
            throw new \Exception("invalid defaultIndexValue params !\n");
        }

        $previousChoice = $this->answer;
        $this->choices($msg, $option, $defaultIndexValue);
        $choice = $this->answer;
        $this->answer = $previousChoice;
        return strtolower($choice) === $option[$indexConfirmOption];
    }
}
