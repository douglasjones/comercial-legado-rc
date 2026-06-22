<?
class Grid{
    
    protected $ALIN_ESQUERDO = 1;
    protected $ALIN_DIREITO = 2;
    protected $ALIN_CENTRO = 3;


    private $arrColuna = array();
    private $arrPk = array();
    private $arrCampoLink = array();
    private $arrLinha = array();
    private $exibirTotalRegistros = false;
    private $intTotalLinhas = 0;
    private $intTotalColuna = 0;
    private $intTipoAlinhamento = 1;
    private $intTipoGrid = 1; //1 - table; 2 - DIV
   
    public function adicionarColuna($strColuna){
        $this->arrColuna[$this->intTotalColuna][0] = $strColuna;
        $this->arrColuna[$this->intTotalColuna][1] = ""; //Alinhamento
        $this->intTotalColuna++;
    }
    
    public function adicionarLinha(){
        
        for($i = 0 ; $i < count($this->arrColuna); $i++){
            $this->arrLinha[$this->intTotalLinhas][$i] = "";
        }
        
        $this->intTotalLinhas++;  
    }
    
    public function setAlinhamentoColuna($intColuna, $intAlinhamento){
        $this->arrColuna[$intColuna][1] = $intAlinhamento;
    }
    
    public function setValor($intLinha, $intColuna, $strValor){
        
        $this->arrLinha[$intLinha][$intColuna] = $strValor;       
    }
   
    public function exibirTotalLinhas($bolExibir = false){
        $this->exibirTotalRegistros = $bolExibir;
    }
    
    public function setCampoLink($strValor,$strPk,$intColuna){
        $this->arrCampoLink[$this->intTotalLinhas][$intColuna] = $strValor;
        
        $this->arrPk[$this->intTotalLinhas][$intColuna] = $strPk;
        
    }
    
    public function exibir(){
        if($intTipoGrid == 1){
            exibirTable();
        }
        else{
            exibirDiv();
        }
    }
    
    private function exibirTable(){
        $cor = 0;
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        for($i = 0; $i < count($this->arrColuna); $i++){
            echo "<th>".$this->arrColuna[$i][0]."</th>";  
        }
        echo"</tr>";
        echo "</thead>";
        
        echo "<tbody>";
        for($j = 0; $j < count($this->arrLinha); $j++){
            
            
            echo "<tr>\n";
            
            for($i = 0; $i < count($this->arrColuna); $i++){
                if($this->arrCampoLink[$j+1][$i] == $this->arrLinha[$j][$i]){
                    echo "<td><a href='javascript: abrirGrid(".$this->arrPk[$j+1][$i].")'>".$this->arrLinha[$j][$i]."</a></td>\n";
                }
                else{
                    switch($this->arrColuna[$i][1]){
                        case $this->ALIN_CENTRO:
                            echo "<td align='center'>".$this->arrLinha[$j][$i]."</td";
                            break;

                        case $this->ALIN_DIREITO:
                            echo "<td align='right'>".$this->arrLinha[$j][$i]."</td>";
                            break;

                        default:  
                            echo "<td align='left'>".$this->arrLinha[$j][$i]."</td>";
                            break;
                    }
                }
            }
            echo"</tr>";
        }
        echo"</tbody>";
        
        //Rodapé
        echo "<tfoot>";
        echo "<tr>";
        echo "<th colspan='".count($this->arrColuna)."'>Total registro(s):". count($this->arrLinha)." </th>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</table>";
    }
    private function exibirDiv(){
        $cor = 0;
        echo"<div class='container col-sm'>";
        echo"<div class='row'>";
        
        for($i = 0; $i < count($this->arrColuna); $i++){
            echo "<div class='titulo border col-sm text-center '>".$this->arrColuna[$i][0]."</div>";  
        }
       
        echo"</div>";
        
        for($j = 0; $j < count($this->arrLinha); $j++){
            
            
            if ($cor == 0){
                echo "<div class='row linha'>\n";
                $cor = 1;
            }
            else{
                echo "<div class='row linha1'>\n";
                $cor = 0;
            }
            
            for($i = 0; $i < count($this->arrColuna); $i++){
                if($this->arrCampoLink[$j+1][$i] == $this->arrLinha[$j][$i]){
                    echo "<div class='border col-sm text-center '><a href='javascript: abrirGrid(".$this->arrPk[$j+1][$i].")'>".$this->arrLinha[$j][$i]."</a></div>\n";
                }
                else{
                    switch($this->arrColuna[$i][1]){
                        case $this->ALIN_CENTRO:
                            echo "<div class='border col-sm text-center '>".$this->arrLinha[$j][$i]."</div>";
                            break;

                        case $this->ALIN_DIREITO:
                            echo "<div class='border col-sm text-right'>".$this->arrLinha[$j][$i]."</div>";
                            break;

                        default:  
                            echo "<div class='border col-sm text-left'>".$this->arrLinha[$j][$i]."</div>";
                            break;
                    }
                }
            }
            echo"</div>";
        }
        echo"<div class='row'>";
        
        //Rodapé
        echo "<div class=' col-sm titulo text-center' colspan='".count($this->arrColuna)."'>Total registro(s):". count($this->arrLinha)." </th>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
    }
}


?>
