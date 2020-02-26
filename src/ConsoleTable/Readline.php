<?php

namespace ConsoleTable;


class Readline{

    private $answer = "";

    public function __construct(string $txt, array $availableParams = [], int $defaultValueIndex = -1)
    {
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

    public function confirm() :bool {
        $previousChoice = $this->answer;
        $this->choices("Choice: ".$this->answer."\nyou confirmed your choice ?", ['y', 'n'], 1);
        $choice = $this->answer;
        $this->answer = $previousChoice;
        return strtolower($choice) === "y";
    }
}
