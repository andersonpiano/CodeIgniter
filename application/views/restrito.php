<section style="min-height: calc(100vh - 83px);" class="light-bg">
			<div class="container">

				<div class="row">
					<div class="col-lg-offset-3 col-lg-6 text-center">
						<div class="section-title">
							<h2>Área Restrita</h2>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-offset-5 col-lg-2 text-center">
						<div class="form-group">
							<a id="btn_your_user" class="btn btn-link" user_id="<?=$user_id?>"><i class="fa fa-user"></i></a>
							<a class="btn btn-link" href="restrito/logoff"><i class="fa fa-sign-out"></i></a>
						</div>
					</div>
				</div>

			<div class="container">
				<ul class="nav nav-tabs">
					<li class="active"><a href="tab_user" role="tab" data-toggle="tab">Usuários</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab_user" class="tab-pane active"></div>
						<div class="container-fluid">
							<h2 class="text-center"><strong>Gerenciar Usuários</strong></h2>
							<a id="btn_add_user" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Adicionar Usuário</i></a>
							<table id="dt_users" class="table table-striped table-bordered">
								<thead>
									<tr class="tableheader">
										<th>Login</th>
										<th>Nome</th>
										<th>Email</th>
										<th class="dt-center no-sort">Ações</th>
									</tr> 
								</thead>
								<tbody></tbody></table>
						</div>
				</div>
			</div>
</section>
<div id="modal_user" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">X</button>
			<h4 class="modal-title">Novo Usuário</h4>
		</div>
		<div class="modal-body">
			<form id="form_user">
				<input id="user_id" name="user_id" hidden>

				<div class="form-group">
					<label class="col-lg-2 control-label">Login</label>
					<div class="col-lg-10">
						<input id="user_login" name="user_login" class="form-control" maxlength="30">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Nome Completo</label>
					<div class="col-lg-10">
						<input id="user_nome" name="user_nome" class="form-control" maxlength="100">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">E-mail</label>
					<div class="col-lg-10">
						<input id="user_email" name="user_email" class="form-control" maxlength="100">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Confirmar E-mail</label>
					<div class="col-lg-10">
						<input id="user_email_confirm" name="user_email_confirm" class="form-control" maxlength="100">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Senha</label>
					<div class="col-lg-10">
						<input type="password" id="user_password" name="user_password" class="form-control">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Confirmar Senha</label>
					<div class="col-lg-10">
						<input type="password" id="user_password_confirm" name="user_password_confirm" class="form-control">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group text-center">
            		<button type="submit" id="btn_save_user" class="btn btn-primary">
              		<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar</button>
            		<span class="help-block"></span>
          		</div>

			</form>
		</div>
	</div>
</div>
</div>
