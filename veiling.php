<?php
function veilingItem($aantal)
{
    for ($i = 1; $i <= $aantal; $i++) {
        if ($i % 3 == 1) {
            echo '<div class="row">';
        }
        $randomTime = rand(0, 239) . ":" . rand(0, 59) . ":" . rand(0, 59);
        $euro = "&euro;" . rand(0, 500);
        echo '<div class="col s12 m12 l4">
                <div class="card">
                    <div class="card-image">
                        <img src="img/han.jpg">
                    </div>
                    <div class="card-content">
                    <span class="card-title black-text">Veiling ' . $i . '</span>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    </div>
                    <div class="card-content">  
                        <p class="veiling-countdown">' . $randomTime . '<span class="right">' . $euro . '</span></p>
                    </div>
                    <div class="card-action">
                        <a class="btn light-green darken-2" href="#">Bekijk veiling</a>
                    </div>
                </div>
            </div>';
        if ($i % 3 == 0) {
            echo '</div>';
        }
    }
}

?>

