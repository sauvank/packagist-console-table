<?php

namespace ConsoleTable;


class Readline{

    private $answer = "";
    private $optionCallback = "";

    public function __construct(string $txt, array $options = [], array $optionCallback = [],  int $defaultValueIndex = -1)
    {
        if($defaultValueIndex >= 0 && $defaultValueIndex > count($options)){
            throw new \Exception("invalid defaultValueIndex params !\n");
            return;
        }

        $this->optionCallback = $optionCallback;

        $this->choices($txt, $options, $defaultValueIndex);
        return $this;
    }

    private function choices(string $txt, array $options, int $defaultValueIndex){

        $activeParams = count($options) > 0;

        // Upper default value params if is active.
        if($activeParams && $defaultValueIndex >= 0){
            $options[$defaultValueIndex] = strtoupper(ucfirst($options[$defaultValueIndex]));
        }

        $txt = $activeParams ? $txt .= " (". implode('/', $options) . ")" : $txt;

        echo $txt .= "\n";
        $this->answer = readline("> ");

        $isOptionC = $this->checkOptionCallback();

        if($isOptionC){
            return;
        }


        if($activeParams){
            if(strlen($this->answer) === 0 && $defaultValueIndex >= 0){
                $this->answer = $options[$defaultValueIndex];
            }elseif (array_search(strtolower($this->answer),  array_map('strtolower', $options)) === false){
                $result = new Readline("The answer $this->answer is invalid, please enter valid value", $options,$this->optionCallback, $defaultValueIndex);
                $this->answer = $result->getAnswer();
            }
        }
    }

    public function getAnswer(){
        return $this->answer;
    }

    public function confirm() :bool {
        $previousChoice = $this->answer;
        $this->choices("Choice: ".$this->answer."\nyou confirmed your choice ?", ['y', 'n'], $this->optionCallback, 1);
        $choice = $this->answer;
        $this->answer = $previousChoice;
        return strtolower($choice) === "y";
    }

    /**
     * Check if user give option with callback.
     * @param array $optionCallback
     * @return bool
     */
    private function checkOptionCallback(): bool {
        $answer = $this->answer;

        $search = array_search($answer, array_column($this->optionCallback, 'name') );
        if($search !== false){
            $this->optionCallback[$search]['action']();
            return true;
        }

        return false;
    }
}
