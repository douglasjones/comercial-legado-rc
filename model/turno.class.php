<?

class turno{

    private $pk;
    private $ds_turno;

    
    
    function __construct(){
        $this->pk = null;
        
        $this->ds_turno = null;

    }    
    
    public function getpk(){return $this->pk;}
    
    function getds_turno(){return $this->ds_turno;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    
    function setds_turno($ds_turno){ $this->ds_turno = $ds_turno;}

    
}

?>
