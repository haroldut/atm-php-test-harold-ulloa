<?php
declare(strict_types=1);
class IncorrectAmountException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class ATM
{
    /**
    * @param int $amount
    * @param int[] $availableBanknotes
    * @return int[]
    * @throws IncorrectAmountException
    */
    public function getBanknotes(int $amount, array $availableBanknotes): array
    {
        $isValid = $amount /  min($availableBanknotes) > 1 && $amount % min($availableBanknotes) == 0;
    
        if(!$isValid){
            throw new IncorrectAmountException('This ATM do not serve the denomination requested');
        }
        
        $amountModule = $amount;
        
        if(in_array("500", $availableBanknotes)){
            $multipleOf500 = $amountModule / 500 >= 1;
            
            if($multipleOf500) {
                $result['500'] = floor($amountModule / 500);
                $amountModule =  $amountModule % 500;
                if($amountModule == 0)
                    return $result;
            }    
        }
        
        if(in_array("200", $availableBanknotes)){
            $multipleOf200 = $amountModule / 200 >= 1;
            
            if($multipleOf200) {
                $result['200'] = floor($amountModule / 200);
                $amountModule =  $amountModule % 200;
                if($amountModule == 0)
                    return $result;
            }
        }
        
        if(in_array("100", $availableBanknotes)){
            $multipleOf100 = $amountModule / 100 >= 1;
            
            if($multipleOf100) {
                $result['100'] = floor($amountModule / 100);
                $amountModule =  $amountModule % 100;
                if($amountModule == 0)
                    return $result;
            }
        }
        
        if(in_array("50", $availableBanknotes)){
            $multipleOf50 = $amountModule / 50 >= 1;
            
            if($multipleOf50) {
                $result['50'] = floor($amountModule / 50);
                $amountModule =  $amountModule % 50;
                if($amountModule == 0)
                    return $result;
            }
        }
        
        if(in_array("20", $availableBanknotes)){
            $multipleOf20 = $amountModule / 20 >= 1;
            
            if($multipleOf20) {
                $result['20'] = floor($amountModule / 20);
                $amountModule =  $amountModule % 20;
                if($amountModule == 0)
                    return $result;
            }
        }
        
        if(in_array("10", $availableBanknotes)){
            $multipleOf10 = $amountModule / 10 >= 1;
            
            if($multipleOf10) {
                $result['10'] = floor($amountModule / 10);
                $amountModule =  $amountModule % 10;
                if($amountModule == 0)
                    return $result;
            }
        }
        
        return $result;
    }
}

/////////////
$atm = new ATM();

// Call 1. Expected result: [20 => 1, 50 => 2]
try {
    $result1 = $atm->getBanknotes(120, [20, 50]);

    echo "Result 1: ";
    foreach ($result1 as $key => $value) {
        echo $key." ".$value." & ";
    }
    echo "\n";
} catch (IncorrectAmountException $e) {
    echo $e->getMessage();
}

// Call 2. Expected result: [10 => 3, 50 => 1, 200 => 2]
try {
    $result2 = $atm->getBanknotes(480, [10, 50, 100, 200, 500]);

    echo "Result 2: ";
    foreach ($result2 as $key => $value) {
        echo $key." ".$value." & ";
    }
    echo "\n";
} catch (IncorrectAmountException $e) {
    echo $e->getMessage();
}

// Call 3. Expected result: IncorrectAmountException to be thrown
try {
    $result3 = $atm->getBanknotes(58, [10, 50]);

    echo "Result 3: ";
    foreach ($result3 as $key => $value) {
        echo $key." ".$value." & ";
    }
    echo "\n";
} catch (IncorrectAmountException $e) {
    echo $e->getMessage();
}
