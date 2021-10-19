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

        rsort($availableBanknotes);

        $amountModule = $amount;
        
        foreach ($availableBanknotes as $value) {
                $multipleOf = $amountModule / $value >= 1;
                
                if($multipleOf) {
                    $result[$value] = floor($amountModule / $value);
                    $amountModule =  $amountModule % $value;
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
    echo "\n";
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
    echo "\n";
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
    echo "\n";
}

// Call 4. Expected result: [5 => 1, 10 => 1, 20 => 1, 50 => 1]
try {
    $result4 = $atm->getBanknotes(85, [5, 10, 20, 50]);

    echo "Result 4: ";
    foreach ($result4 as $key => $value) {
        echo $key." ".$value." & ";
    }
    echo "\n";
} catch (IncorrectAmountException $e) {
    echo $e->getMessage();
    echo "\n";
}

