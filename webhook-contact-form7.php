<?php

// Integrando o plugin Contact Form 7 ao CV CRM através de webhook
// Desenvolvido por Nádya Arabatzoglou
// Dúvidas, Readme -> https://github.com/nadyadg/cvcrm-contactform-7/

// Recebendo dados do Contact Form 7 do seu site

header("Access-Control-Allow-Origin: *");
header('Cache-Control: no-cache, must-revalidate'); 
header("Content-Type: text/plain; charset=UTF-8");
header("HTTP/1.1 200 OK");

$jsoninput = file_get_contents("php://input");

// Caso o arquivo não exista, redireciona para página inicial

if(file_get_contents("php://input") == FALSE){
    header("Location: https://www.seusite.com.br");
exit();
}

// Transformando os objetos em variáveis
// Use nas chaves o mesmo nome que você colocou nos campos do contact form 
// Caso esteja usando hífem em algum campo, trate como objeto literal '', ou remova o hífen ;)

        $jsonobj = json_decode($jsoninput); 

		$nome = $jsonobj->nome; 
        $fone = $jsonobj->yourtel; 
        $email = $jsonobj->youremail; 
        $origem = $jsonobj->origem; 
        $midia = $jsonobj->midia; 
        // O post id pega o id da página enviado pelo contact form 7 (special mail tags) 
        $postid = $jsonobj->_post_id;
		
        // Se estiver utilizando parâmetros na url, utilize input hidden GET no contact form 7
        // Coloque os IDS de midia conforme o seu CRM
        // Opções de mídia do CV CRM: 'AP' - 'Aplicativo' / 'AT' - 'Módulo de Atendimento' / 'BC' - 'Busca Compartilhada' / 'BO' - 'Busca Orgânica' / 'CH' - 'Chat Online' / 'CB' - 'ChatBot' / 'DP' - 'Display' / 'EM' - 'Email' / 'FB' - 'Facebook' / 'GO' - 'Google' / 'IT' - 'InstaPage' / 'IG' - 'Instagram' / 'LI' - 'Ligação' / 'MP' - 'Mídia Paga' / 'OP' - 'Outras publicidades' / 'CL' - 'Painel Cliente' / 'CO' - 'Painel Corretor' / 'GE' - 'Painel Gestor' / 'IM' - 'Painel Imobiliária' / 'PV' - 'Painel PDV' / 'PT' - 'Phonetrack' / 'PO' - 'Portais' / 'RF' - 'Referência' / 'SC' - 'Social' / 'TD' - 'Tráfego Direto' / 'TW' - 'Twitter' / 'SI' - 'WebSite' / 'UK' - 'Desconhecido' / 'ND' - 'Não Definido' / 'VO' - 'Vendas Online' / 'RM' - 'Remarketing' /'OU' - 'Outros'. Caso não seja enviado no JSON da requisição, se existir o campo 'modulo', recebe esse valor, se não existir, recebe o valor padrão do sistema (ND)
        
        switch($midia){
                case 'displaygoogle': // exemplo
        $midia2 = "display_google";
        $origem2 = "GO";
        break;
                case 'parametrodaurl':
        $midia2 = "slugdamidianocrm";
        $origem2 = "origem";
        break;
                case 'parametrodaurl':
        $midia2 = "slugdamidianocrm";
        $origem2 = "origem";
        break;
                default: // Caso não esteja utilizando parâmetros de url, preencha abaixo com a midia e origem padrão.
        $midia2 = "slugdamidianocrm";
        $origem2 = "SI";
        break;
          }

        // Para utilizar o mesmo formulário em todos os empreendimentos do site, coloque o id das páginas em "case" e o ID do empreendimento cadastrado no CV CRM na variavel $empreendimento
        // Cadastre uma anotação para registro da conversão

        switch($postid){
                case '123': //exemplo
        $idempreendimento = "5";
        $anotacao = "Cliente cadastrado através do formulário no site. Interesse no empreendimento Res. X";
        break;
                case '':
        $idempreendimento = "";
        $anotacao = "";
        break;
                 default: // Caso você tenha formulário em outras página, utilize aqui um valor padrão para anotação.
        $anotacao = "";
        break;
          }
// Estrutura para enviar ao CV CRM
// Utilize a entrada interações para gravar outras informações como Tipos: 'A' - 'Anotação', 'L' - 'Ligação', 'E' - 'E-mail', 'S' - 'SMS', 'W' - 'Whatsapp'.
// Para mais entradas consulte -> https://docs.cvcrm.com.br/

$data = array(
    'email' => $email,
    'telefone' => $fone,
    'nome' => $nome,
    'permitir_alteracao' => true,
    'midia' => $midia2,
    'idempreendimento' => $idempreendimento, 
    'lead_utilizar_fila' => true,
    'origem' => $origem2,
    'acao' => 'salvar_editar',
        'interacoes' =>array(
            'tipo' => 'A',
            'descricao' => $anotacao 
        )
       
);


$url = "https://nomedaconstrutora.cvcrm.com.br/api/cvio/lead"; //preencha com a url do seu crm
$content = json_encode($data);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("accept: application/json",
   "token: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx", // preencha com o token
   "origemcv: true",
   "Content-Type: application/json",));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Erro ao acessar a URL $url - Status $status, $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}


curl_close($curl);
        
        
        

	
