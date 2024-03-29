<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

	private $key;
	private $token;
  private $cardId;
	private $idList;
	function __construct() {
        parent::__construct();
        // Carrega o model Pessoa
        $this->load->model('pessoa_model', 'PM');
				$this->boardId = '5cd74ef3cbe0948701c37a57';
				$this->key ='ff7347dfb445fa9701e2d4ccdf058950';
				$this->token ='c9f9a25bbefe7f59336c832797cba81d4ab425df5f15f4b3f607eef94bdd3875';
				$this->idList = '5cd750abe20fdd6711d5a986';
				$parameters = array(
					'token' => $this->token,
					'key' => $this->key
				);
					$this->load->library('api',$parameters);
    }

	public function index()	{

		// Busca as informações do model e passa para o array $data
		$data['registros'] = $this->PM->listar_pessoas();
		$this->load->view('template/header');
		$this->load->view('pessoa_cadastrar', $data); // array $data é passado para view pessoa_cadastrar
		$this->load->view('template/footer');

		}

  public function listBoard()
	 {
		 	$boards['registros'] = $this->api->request('get','boards/'.$this->boardId.'/cards');
		 	$this->load->view('template/header');
			$this->load->view('list_board',$boards);
			$this->load->view('template/footer');
	 }
	public function cadastrar(){
		// Seta as regras para validação do formulário
		$this->form_validation->set_rules('nome', '<strong>Nome</strong>', 'required|trim');
		$this->form_validation->set_rules('sobrenome', '<strong>Sobrenome</strong>', 'required|trim');
		$this->form_validation->set_rules('email', '<strong>E-mail</strong>', 'required|valid_email|trim');
		if($this->form_validation->run() === FALSE){
			$this->index();
		}else{
			// Se é feito o cadastro no bd é retornado true
			if($this->PM->cadastrar() === TRUE){
				$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Seu cadastro foi efetuado sem erros.</div>');
			}else{
				$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Seu cadastro não foi efetuado.</div>');
			}
			redirect('pessoa','refresh');
		}
	}

	public function editar($id_pessoa = NULL){
		if((isset($id_pessoa) && !empty($id_pessoa)) && ($this->PM->listar_pessoa($id_pessoa) !== NULL)){
			// Busca as informação da pessoa pelo id passado no parametro da funcao
			$data['registro'] = $this->PM->listar_pessoa($id_pessoa);

			$this->load->view('template/header');
			$this->load->view('pessoa_editar', $data);
			$this->load->view('template/footer');
		}else{
			redirect('pessoa','refresh');
		}
	}

	public function gravar_edicao(){
		$this->form_validation->set_rules('nome', '<strong>Nome</strong>', 'required|trim');
		$this->form_validation->set_rules('sobrenome', '<strong>Sobrenome</strong>', 'required|trim');
		$this->form_validation->set_rules('email', '<strong>E-mail</strong>', 'required|valid_email|trim');
		if($this->form_validation->run() === FALSE){
			$this->editar($this->input->post('id_pessoa'));
		}else{
			if($this->PM->gravar_edicao($this->input->post('id_pessoa')) === TRUE){
				$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Cadastro editado sem erros.</div>');
			}else{
				$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Não foi possível editar o cadastro.</div>');
			}
			redirect('pessoa','refresh');
		}
	}

	public function deletar($id_pessoal = NULL){
		if((isset($id_pessoal) && !empty($id_pessoal)) && ($this->PM->deletar($id_pessoal) === TRUE)){
			$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Cadastro deletado do banco de dados.</div>');
		}else{
			$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Não foi possível deletar o cadastro.</div>');
		}
		redirect('pessoa','refresh');
	}

	public function sobre() {
		$this->load->view('template/header');
		$this->load->view('sobre');
		$this->load->view('template/footer');
	}

	public function submitapi(){
		$this->load->view('template/header');
		$this->load->view('submitapi');
		$this->load->view('template/footer');
	}

	public function cadastrarCard()
	{

		$data['titulo'] 		= $this->input->post('titulo');
		$data['descricao']  = $this->input->post('descricao');
		$boards['registros'] = $this->api->request('post','cards?idList='.$this->idList.'&name='.$data['titulo'].'&desc='.$data['descricao']);

		//SE boards RETORNAR É QUE GRAVOU;
	}


}
