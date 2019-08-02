<?php
require_once 'db/DB.php';
/**
 * Description of Leads
 *
 * @author pedro
 */
class Leads {
    private $db;
    public function __construct() {
        $this->db = new DB();
    }
 
    /**
     * Description: Obter as informações necessárias para o dashboard do Gestor
     * @param type $user
     * @return array
     */
    public function getDashInfo($user) {
        $resp = array();
        // Novas
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS novas FROM arq_leads WHERE user=:user AND status IN (1,2)", array(':user'=>$user));
        $resp['novas'] = $temp[0]['novas'];
        
         // Agendadas Ativas
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS agendaAtiva FROM `cad_agenda` WHERE user=:user and tipoagenda<>3 and status=1 "
                . "and agendadata<= CURRENT_DATE and agendahora<= CURRENT_TIME", array(':user'=>$user));
        $resp['agendaAtiva'] = $temp[0]['agendaAtiva'];
        // Agendadas
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS agendadas FROM arq_leads WHERE user=:user AND status IN (6,7)", array(':user'=>$user));
        $resp['agendadas'] = $temp[0]['agendadas'];  
        // Anuladas no dia
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS anuladasDia FROM arq_leads WHERE user=:user AND status IN (3,4,5) AND DATE(datastatus)=CURRENT_DATE",
                array(':user'=>$user));
        $resp['anuladasDia'] = $temp[0]['anuladasDia'];          
        // Aguardamdocumentação
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS aguardaDoc FROM `cad_agenda` WHERE user=:user and tipoagenda=3 and status=1 and agendadata >= CURRENT_DATE",
                array(':user'=>$user));
        $resp['aguardaDoc'] = $temp[0]['aguardaDoc'];
        // Documentação atrasada
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS docAtrasada FROM `cad_agenda` WHERE user=:user and tipoagenda=3 and status=1 and agendadata < CURRENT_DATE",
                array(':user'=>$user));
        $resp['docAtrasada'] = $temp[0]['docAtrasada'];        
        // Aguardam documentação pedida pelo analista
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS docAtrasada FROM arq_leads WHERE user=:user AND status = 21", array(':user'=>$user));
        $resp['docAnalista'] = $temp[0]['docAtrasada'];   
        // Iniciados no Portal
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS iniPortal FROM arq_leads WHERE user=:user AND status = 37", array(':user'=>$user));
        $resp['iniPortal'] = $temp[0]['iniPortal'];  
        // Documentação recebida pelo Portal
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS docPortal FROM arq_leads WHERE user=:user AND status = 36", array(':user'=>$user));
        $resp['docPortal'] = $temp[0]['docPortal'];  
        // Aguardam documentação no Portal
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS aguardaDocPortal FROM arq_leads WHERE user=:user AND status = 38", array(':user'=>$user));
        $resp['aguardaDocPortal'] = $temp[0]['aguardaDocPortal'];  
        // Documentação recebida pela API BPS
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS docBPS FROM arq_leads WHERE user=:user AND status = 39", array(':user'=>$user));
        $resp['docBPS'] = $temp[0]['docBPS'];  
        
        // Informações sobre a situação dos processos passados para a Analise
        // Passaram para Analise no Mês
        $temp = array();
        $temp = $this->db->query("SELECT count(DISTINCT(lead)) AS toAnaliseMes FROM `arq_histprocess` WHERE status IN(10,11) AND user=:user "
                . " AND YEAR(data)= YEAR(CURRENT_DATE) AND MONTH(data)=MONTH(CURRENT_DATE)", array(':user'=>$user));
        $resp['toAnaliseMes'] = $temp[0]['toAnaliseMes'];
        // Passaram para Analise no Dia
        $temp = array();
        $temp = $this->db->query("SELECT count(DISTINCT(lead)) AS toAnalisDia FROM `arq_histprocess` WHERE status IN(10,11) AND user=:user "
                . " AND DATE(data)= CURRENT_DATE", array(':user'=>$user));
        $resp['toAnalisDia'] = $temp[0]['toAnalisDia'];
        // Em Analise 
        $temp = array();
        $temp = $this->db->query("SELECT count(*) AS inAnalise FROM arq_leads WHERE user=:user AND status IN(13, 20, 22)", array(':user'=>$user));
        $resp['inAnalise'] = $temp[0]['inAnalise'];
        // Financiados no Mês
        $temp = array();
        $temp = $this->db->query("SELECT count(DISTINCT(lead)) AS financidosMes FROM `arq_histprocess` WHERE status IN(17,24) AND user=:user "
                . " AND YEAR(data)= YEAR(CURRENT_DATE) AND MONTH(data)=MONTH(CURRENT_DATE)", array(':user'=>$user));
        $resp['financidosMes'] = $temp[0]['financidosMes'];        
        // Financiadas no Dia
        $temp = array();
        $temp = $this->db->query("SELECT count(DISTINCT(lead)) AS financiadosDia FROM `arq_histprocess` WHERE status IN(17, 24) AND user=:user "
                . " AND DATE(data)= CURRENT_DATE", array(':user'=>$user));
        $resp['financiadosDia'] = $temp[0]['financiadosDia'];    
        
        // Estão aprovados no momento
        $temp= array();
        $temp = $this->db->query("SELECT count(*) AS aprovados FROM arq_leads WHERE user=:user AND status IN(16,23) ", array(':user'=>$user));
        $resp['aprovados'] = $temp[0]['aprovados'];
        // Recusados no Mês
        $temp= array();
        $temp = $this->db->query("SELECT count(*) AS recusados FROM arq_leads WHERE user=:user  AND status IN(14,15,18,19,25) AND "
                . " YEAR(datastatus)= YEAR(CURRENT_DATE) AND MONTH(datastatus)=MONTH(CURRENT_DATE) ", array(':user'=>$user));
        $resp['recusados'] = $temp[0]['recusados'];
        
        return $resp;
    }
  
   }
        
