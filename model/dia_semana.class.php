<?

class dia_semana{

    private $pk;
    
    private $ds_dia_semana;

    
    
    function __construct(){
        $this->pk = null;
        
        $this->ds_dia_semana = null;

    }    
    
    public function getpk(){return $this->pk;}
    
    function getds_dia_semana(){return $this->ds_dia_semana;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    
    function setds_dia_semana($ds_dia_semana){ $this->ds_dia_semana = $ds_dia_semana;}

    
}

?>
