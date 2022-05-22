<?php

class PopUp{
    public $modalHtmlCode1 = '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    
                    
                
';
    public $modalHtmlCode2='</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">';
    public $modalHtmlCode3='</div>
                <div class="modal-footer">
                    <button data-dismiss="modal" type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $("#myModal").modal(\'show\');
    });
</script>';
    
    public function CreatePopUp($title, $message){
        echo $this->modalHtmlCode1.$title.$this->modalHtmlCode2.$message.$this->modalHtmlCode3;
    }
    
}
