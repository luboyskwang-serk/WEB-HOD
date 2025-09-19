<div class="container-sm mt-4 mb-5 ps-0 pe-0  pb-5   "  >
    <div class="row card-body pt-5 text-white mb-4">
                </div>
                    <?php 
                    if(isset($_GET['subpage']) && $_GET['subpage'] == "cpass"){
                        require_once('page/cpass.php'); 
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "cimg"){
                        require_once('page/cimg.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "topuphis"){
                        require_once('page/topuphis.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "myapp"){
                        require_once('page/myapp.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "buyhis" ){
                        require_once('page/buyhis.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "buyhisid" ){
                        require_once('page/buyhisidpass.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "histermgame" ){
                        require_once('page/histermgame.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "hiscashcard" ){
                        require_once('page/hiscashcard.php');
                    } elseif(isset($_GET['subpage']) && $_GET['subpage'] == "hisphoneTopup" ){
                        require_once('page/hisphoneTopup.php');
                    } else{
                        require_once('page/cpass.php');
                    }
                    ?>
            </div>
    </div>
</div>