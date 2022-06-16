<?php 
/*foreach($personsList as $person)
    echo $person . '\n';*/
for($i = 0; $i < 50; $i++){
    foreach($personsList[$i] as $atr)
        echo $atr . ' ';
    echo '<br>';
}

echo '--------------------------------------------------------------';

/*foreach($newList['personID'] as $atr)
    echo $atr . ' ';*/
echo '<br>';
foreach($newList['new'] as $atr)
    //echo $atr . ' ';
    print_r($atr);
echo '<br>';
foreach($newList['newGet'] as $atr)
    echo $atr . ' ';
echo '<br>';
echo $msg;
echo '......................';
foreach($newList['personName'] as $new){
    foreach($new as $atr)
        echo $atr . ' ';
    echo '<br>';
}
?>