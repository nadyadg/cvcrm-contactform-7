# Integrando o plugin Contact Form 7 ao CV CRM através de webhook
Se a sua construtora tem um site em wordpress e utiliza o CV CRM, aprenda a integrar o Contact Form 7 através de webhook.

# Sobre o projeto
Esse trabalho nasceu da necessidade de integrar os formulários de contato do site da construtora que trabalho ao CRM que utilizamos que é o CV CRM (conhecido também como Construtor de Vendas). Também precisava enviar parâmetros na URL para identificar a entrada dos leads e identificar o empreendimento através do id da página.

A documentação pública das APIs existentes no CV CV CRM você vai encontrar em https://docs.cvcrm.com.br/ 

# Para essa integração você vai precisar de:
- Um site em wordpress
- Plugin contact form 7, instalado e ativado - Download https://wordpress.org/plugins/contact-form-7/
- Plugin CF7 to Webhook, instalado e ativado - Download https://wordpress.org/plugins/cf7-to-zapier/
- Acesso via FTP ao servidor
- Acesso ao CV CRM
- Conhecimentos básicos de PHP, JSON e Wordpress

# Instruções
Após instalar e ativar os plugins necessários, crie seu primeiro formulário. Após, faça as configurações na aba "Mail" incluindo [_post_id] no campo "corpo da mensagem" para incluir o id do post no envio. Clique na aba "Webhook". Marque a opção "Send to Webhook". No campo Special mail tags, inclua [_post_id]. Clique em salvar.

<b>Obs: Não use hífen "-" nos nomes dos campos do formulário. Se estiver usando por exemplo "your-mail" no campo e-mail, altere para "yourmail" ou utilize "_".</b>

![Editar-formulário-de-contato-‹--—-WordPress](https://github.com/nadyadg/cvcrm-contactform-7/assets/74943083/d4f5f298-4b93-4cbc-a924-7e595ed55b29)


Baixe e abra o arquivo webhook-contact-form7.php e edite conforme os campos do seu formulário, e de acordo com as suas necessidades. Não esqueça de incluir o token do usuário de integrações do CV CRM. Leia mais em -> 
https://suporte.cvcrm.com.br/kb/article/139171/como-gerar-um-token-painel-do-gestor?ticketId=&q=token. Salve o arquivo e coloque em uma pasta do seu servidor web através do FTP. 
Com o caminho da pasta deste arquivo em mãos, volte na aba "webhook" do contact form 7 e cole a url absoluta no campo "webhook URL"

![Editar-formulário-de-contato-‹--—-WordPress2](https://github.com/nadyadg/cvcrm-contactform-7/assets/74943083/44d08473-15a3-4347-8afc-af06489972b4)



O arquivo webhook-contact-form7.php esta comentado com mais instruções.

# Base de Consulta
- Documentação de API CV CRM https://docs.cvcrm.com.br/
- Special Mail Tags - Contact form 7 https://contactform7.com/special-mail-tags/

# Esse código pode melhorar :)
Contribua ;)

<i>Nádya S. Arabatzoglou
nadyadg@gmail.com</i>
