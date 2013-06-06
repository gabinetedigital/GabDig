<?php

function twentyeleven_procergs_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Sobre', 'twentyeleven' ),
		'id' => 'sidebar-6',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Resultados 2012', 'twentyeleven' ),
		'id' => 'sidebar-7',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Resultados 2011', 'twentyeleven' ),
		'id' => 'sidebar-8',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Comite de Transito', 'twentyeleven' ),
		'id' => 'sidebar-9',
		'description' => __( 'A sidebar to show widgets on Comite Transito page', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Artigo Hierárquico', 'twentyeleven' ),
		'id' => 'sidebar-10',
		'description' => __( 'A sidebar to show widgets on Artigo Hierarquico', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_procergs_widgets_init' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'artigo-herarquico',
		array(
			'labels' => array(
				'name' => __( 'Artigo Hierárquico' ),
				'singular_name' => __( 'Artigo Hierárquico' ),
				'add_new_item' => __('Adicionar novo Artigo Hierárquico'),
				'edit_item' => __( 'Editar Artigo Hierárquico' ),
				'add_new' => __( 'Novo Artigo Hierárquico' ),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'lei'),
			'exclude_from_search' => true,
			'show_in_menu' => true,
			'hierarchical' => 'true',
			'taxonomies' => array(
				'category',
				'post_tag'
			),
			'supports' => array(
				'title','editor','author','page-attributes','comments','revisions','custom-fields',
			),
		)
	);
}

// ===========================================================

global $meta_boxes_artigo_hierarquico;

$prefix = 'artigo_hierarquico_';

$meta_boxes_artigo_hierarquico = array();

$meta_boxes_artigo_hierarquico[] = array(
		'id' => $prefix.'configuracao-pai',
		'title' => 'Configurações de Exibição de item Pai',
		'pages' => array('artigo-herarquico'),
		'context'=> 'normal',
		'priority'=> 'high',
		'fields' => array(
				array(
						'name'		=> 'Banner',
						'id'		=> $prefix . 'banner',
						'desc'		=> 'Caminho da imagem para o banner superior',
						'type'		=> 'text'
				),
				array(
						'name'		=> 'Comentários nos Filhos',
						'id'		=> $prefix . 'comentarios_filhos',
						'desc'		=> 'Habilita ou não comentar nas partes do texto',
						'type'		=> 'checkbox'
				),
				array(
						'name'		=> 'Comentário Principal',
						'id'		=> $prefix . 'comentario_master',
						'desc'		=> 'Habilita ou não o comentário principal da página',
						'type'		=> 'checkbox'
				),
				array(
						'name'		=> 'Abas',
						'id'		=> $prefix . 'abas',
						'desc'		=> 'Habilita ou não a visualização por Abas do artigo (não habilitar ao mesmo tempo com Sanfona)',
						'type'		=> 'checkbox'
				),
				array(
						'name'		=> 'Sanfona',
						'id'		=> $prefix . 'sanfona',
						'desc'		=> 'Habilita ou não o recolhimento das partes do texto (não habilitar ao mesmo tempo com Abas)',
						'type'		=> 'checkbox'
				),		)
);

$meta_boxes_artigo_hierarquico[] = array(
		'id' => $prefix.'configuracao-filho',
		'title' => 'Configurações de Exibição de item Filho',
		'pages' => array('artigo-herarquico'),
		'context'=> 'normal',
		'priority'=> 'high',
		'fields' => array(
				array(
						'name'		=> 'Inibir comentários neste item',
						'id'		=> $prefix . 'inibir_comentarios',
						'desc'		=> 'Desabilitar comentários apenas neste item, mesmo que o comentário nos filhos esteja habilitado',
						'type'		=> 'checkbox'
				),
				)
);


function wp_artigo_hierarquico_register_meta_boxes()
{
	global $meta_boxes_artigo_hierarquico;

	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes_artigo_hierarquico as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}

add_action('admin_init', 'wp_artigo_hierarquico_register_meta_boxes' );

// ===========================================================
// Página de configurações do GD
// ===========================================================
function gd_config_settings() {
	$msg = "";
	if (isset($_POST["update_settings"])) {
	    $base_url = esc_attr($_POST["BASE_URL"]);
    	update_option("gd_base_url", $base_url);

        $date_format = esc_attr($_POST["DATE_FORMAT"]);
        update_option("gd_date_format", $date_format);

	    $valor_investimentos = esc_attr($_POST["VALOR_INVESTIMENTOS"]);
    	update_option("gd_valor_investimentos", $valor_investimentos);

	    $pairwise_server = esc_attr($_POST["PAIRWISE_SERVER"]);
    	update_option("gd_pairwise_server", $pairwise_server);

	    $pairwise_username = esc_attr($_POST["PAIRWISE_USERNAME"]);
    	update_option("gd_pairwise_username", $pairwise_username);

    	$pairwise_password = esc_attr($_POST["PAIRWISE_PASSWORD"]);
    	update_option("gd_pairwise_password", $pairwise_password);

    	$twitter_consumer_key = esc_attr($_POST["TWITTER_CONSUMER_KEY"]);
    	update_option("gd_twitter_consumer_key", $twitter_consumer_key);

    	$twitter_consumer_secret = esc_attr($_POST["TWITTER_CONSUMER_SECRET"]);
    	update_option("gd_twitter_consumer_secret", $twitter_consumer_secret);

    	$facebook_app_id = esc_attr($_POST["FACEBOOK_APP_ID"]);
    	update_option("gd_facebook_app_id", $facebook_app_id);

    	$facebook_app_secret = esc_attr($_POST["FACEBOOK_APP_SECRET"]);
    	update_option("gd_facebook_app_secret", $facebook_app_secret);

    	$facebook_comment_moderators = esc_attr($_POST["FACEBOOK_COMMENT_MODERATORS"]);
    	update_option("gd_facebook_comment_moderators", $facebook_comment_moderators);

    	$facebook_comment_url = esc_attr($_POST["FACEBOOK_COMMENT_URL"]);
    	update_option("gd_facebook_comment_url", $facebook_comment_url);

    	$votacao_url = esc_attr($_POST["VOTACAO_URL"]);
    	update_option("gd_votacao_url", $votacao_url);

    	$votacao_root = esc_attr($_POST["VOTACAO_ROOT"]);
    	update_option("gd_votacao_root", $votacao_root);

    	$votacao_altura = esc_attr($_POST["VOTACAO_ALTURA"]);
    	update_option("gd_votacao_altura", $votacao_altura);

    	$twitter_stream_username = esc_attr($_POST["TWITTER_STREAM_USERNAME"]);
    	update_option("gd_twitter_stream_username", $twitter_stream_username);

    	$twitter_stream_password = esc_attr($_POST["TWITTER_STREAM_PASSWORD"]);
    	update_option("gd_twitter_stram_password", $twitter_stream_password);

    	$twitter_mayor_username = esc_attr($_POST["TWITTER_MAYOR_USERNAME"]);
    	update_option("gd_twitter_mayor_username", $twitter_mayor_username);

    	$twitter_hash_cabecalho = esc_attr($_POST["TWITTER_HASH_CABECALHO"]);
    	update_option("gd_twitter_hash_cabecalho", $twitter_hash_cabecalho);

    	$galerias_destacadas_id = esc_attr($_POST["GALERIAS_DESTACADAS_ID"]);
    	update_option("gd_galerias_destacadas_id", $galerias_destacadas_id);

    	$video_paginacao = esc_attr($_POST["VIDEO_PAGINACAO"]);
    	update_option("gd_video_paginacao", $video_paginacao);

    	$from_addr = esc_attr($_POST["FROM_ADDR"]);
    	update_option("gd_from_addr", $from_addr);

    	$smtp = esc_attr($_POST["SMTP"]);
    	update_option("gd_smtp", $smtp);

        $gdobra_usuario_admin = esc_attr($_POST["GDOBRA_USUARIO_ADMIN"]);
    	update_option("gd_gdobra_usuario_admin", $gdobra_usuario_admin);

    	$gdobra_apikey = esc_attr($_POST["GDOBRA_APIKEY"]);
    	update_option("gd_gdobra_apikey", $gdobra_apikey);

        $gdobra_privatekey = esc_attr($_POST["GDOBRA_PRIVATEKEY"]);
    	update_option("gd_gdobra_privatekey", $gdobra_privatekey);

        $gdobra_parturl = esc_attr($_POST["GDOBRA_PARTURL"]);
    	update_option("gd_gdobra_parturl", $gdobra_parturl);

        $gdobra_url = esc_attr($_POST["GDOBRA_URL"]);
        update_option("gd_gdobra_url", $gdobra_url);

        $password_remainder_subject = esc_attr($_POST["PASSWORD_REMAINDER_SUBJECT"]);
        update_option("gd_password_remainder_subject", $password_remainder_subject);

        $password_remainder_msg = esc_attr($_POST["PASSWORD_REMAINDER_MSG"]);
        update_option("gd_password_remainder_msg", $password_remainder_msg);

        $welcome_subject = esc_attr($_POST["WELCOME_SUBJECT"]);
        update_option("gd_welcome_subject", $welcome_subject);

        $welcome_msg = esc_attr($_POST["WELCOME_MSG"]);
        update_option("gd_welcome_msg", $welcome_msg);

        $comite_to_email = esc_attr($_POST["COMITE_TO_EMAIL"]);
        update_option("gd_comite_to_email", $comite_to_email);

        $comite_subject = esc_attr($_POST["COMITE_SUBJECT"]);
        update_option("gd_comite_subject", $comite_subject);

        $comite_msg = esc_attr($_POST["COMITE_MSG"]);
        update_option("gd_comite_msg", $comite_msg);

        $seguirobra_subject = esc_attr($_POST["SEGUIROBRA_SUBJECT"]);
        update_option("gd_seguirobra_subject", $seguirobra_subject);

        $seguirobra_msg = esc_attr($_POST["SEGUIROBRA_MSG"]);
    	update_option("gd_seguirobra_msg", $seguirobra_msg);

    	$msg = "<h2>Configurações atualizadas!</h2>";
	}else{
		# => Busca as configurações já gravadas
		$base_url = get_option("gd_base_url");
        $date_format = get_option("gd_date_format");
	    $valor_investimentos = get_option("gd_valor_investimentos");
	    $pairwise_server = get_option("gd_pairwise_server");
	    $pairwise_username = get_option("gd_pairwise_username");
    	$pairwise_password = get_option("gd_pairwise_password");
    	$twitter_consumer_key = get_option("gd_twitter_consumer_key");
    	$twitter_consumer_secret = get_option("gd_twitter_consumer_secret");
    	$facebook_app_id = get_option("gd_facebook_app_id");
    	$facebook_app_secret = get_option("gd_facebook_app_secret");
    	$facebook_comment_moderators = get_option("gd_facebook_comment_moderators");
    	$facebook_comment_url = get_option("gd_facebook_comment_url");
    	$votacao_url = get_option("gd_votacao_url");
    	$votacao_root = get_option("gd_votacao_root");
    	$votacao_altura = get_option("gd_votacao_altura");
    	$twitter_stream_username = get_option("gd_twitter_stream_username");
    	$twitter_stream_password = get_option("gd_twitter_stram_password");
    	$twitter_mayor_username = get_option("gd_twitter_mayor_username");
    	$twitter_hash_cabecalho = get_option("gd_twitter_hash_cabecalho");
    	$galerias_destacadas_id = get_option("gd_galerias_destacadas_id");
    	$video_paginacao = get_option("gd_video_paginacao");
    	$from_addr = get_option("gd_from_addr");
    	$smtp = get_option("gd_smtp");
		$gdobra_usuario_admin = get_option("gd_gdobra_usuario_admin");
		$gdobra_apikey = get_option("gd_gdobra_apikey");
		$gdobra_privatekey = get_option("gd_gdobra_privatekey");
		$gdobra_parturl = get_option("gd_gdobra_parturl");
		$gdobra_url = get_option("gd_gdobra_url");

        $password_remainder_subject = get_option("gd_password_remainder_subject");
        $password_remainder_msg = get_option("gd_password_remainder_msg");
        $welcome_subject = get_option("gd_welcome_subject");
        $welcome_msg = get_option("gd_welcome_msg");
        $comite_to_email = get_option("gd_comite_to_email");
        $comite_subject = get_option("gd_comite_subject");
        $comite_msg = get_option("gd_comite_msg");
        $seguirobra_subject = get_option("gd_seguirobra_subject");
        $seguirobra_msg = get_option("gd_seguirobra_msg");

	}

?>
    <div class="wrap">
        <?php screen_icon('themes'); ?> <h2>Opções de configuração do Gabinete Digital</h2>
		<?php if ($msg != ""): ?>
			<h3><?php echo $msg ?>
		<?php endif ?>
        <form method="POST" action="">
        	<input type="hidden" name="update_settings" value="Y" />
            <table class="form-table gdtable">
            	<tr valign="top"><th colspan=2>
            		<h2>Gerais</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="BASE_URL">
                            Url principal (BASE_URL)
                        </label>
                    </th>
                    <td><input type="text" name="BASE_URL" value="<?php echo $base_url;?>" size="25" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="DATE_FORMAT">
                            Formato da Data (DATE_FORMAT)
                        </label>
                    </th>
                    <td><input type="text" name="DATE_FORMAT" value="<?php echo $date_format;?>" size="25" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="VALOR_INVESTIMENTOS">
                            Valor de investimentos no estado (VALOR_INVESTIMENTOS)
                        </label>
                    </th>
                    <td><input type="text" name="VALOR_INVESTIMENTOS" value="<?php echo $valor_investimentos;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Pairwise</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="PAIRWISE_SERVER">
                            Servidor do Pairwise (PAIRWISE_SERVER)
                        </label>
                    </th>
                    <td><input type="text" name="PAIRWISE_SERVER" value="<?php echo $pairwise_server;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="PAIRWISE_USERNAME">
                            Usuário de acesso ao Pairwise (PAIRWISE_USERNAME)
                        </label>
                    </th>
                    <td><input type="text" name="PAIRWISE_USERNAME" value="<?php echo $pairwise_username;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="PAIRWISE_PASSWORD">
                            Senha de acesso ao Pairwise (PAIRWISE_PASSWORD)
                        </label>
                    </th>
                    <td><input type="text" name="PAIRWISE_PASSWORD" value="<?php echo $pairwise_password;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Login via Twitter</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_CONSUMER_KEY">
                            Consumer Key (TWITTER_CONSUMER_KEY)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_CONSUMER_KEY" value="<?php echo $twitter_consumer_key;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_CONSUMER_SECRET">
                            Consumer Secret (TWITTER_CONSUMER_SECRET)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_CONSUMER_SECRET" value="<?php echo $twitter_consumer_secret;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Login via Facebook</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="FACEBOOK_APP_ID">
                            Id da aplicação (FACEBOOK_APP_ID)
                        </label>
                    </th>
                    <td><input type="text" name="FACEBOOK_APP_ID" value="<?php echo $facebook_app_id;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="FACEBOOK_APP_SECRET">
                            Chave secreta da aplicação do Facebook (FACEBOOK_APP_SECRET)
                        </label>
                    </th>
                    <td><input type="text" name="FACEBOOK_APP_SECRET" value="<?php echo $facebook_app_secret;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Comentários via Facebook</h2>
            	</td>

                <tr valign="top">
                    <th scope="row">
                        <label for="FACEBOOK_COMMENT_URL">
                            URL base para comentários via Facebook (FACEBOOK_COMMENT_URL)
                        </label>
                    </th>
                    <td><input type="text" name="FACEBOOK_COMMENT_URL" value="<?php echo $facebook_comment_url;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="FACEBOOK_COMMENT_MODERATORS">
                            Moderadores para comentários no Facebook (FACEBOOK_COMMENT_MODERATORS)
                        </label>
                    </th>
                    <td><input type="text" name="FACEBOOK_COMMENT_MODERATORS" value="<?php echo $facebook_comment_moderators;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Votação na capa do site</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="VOTACAO_URL">
                            URL completa da página de votação (VOTACAO_URL)
                        </label>
                    </th>
                    <td><input type="text" name="VOTACAO_URL" value="<?php echo $votacao_url;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="VOTACAO_ROOT">
                            URL base do site de votação (VOTACAO_ROOT)
                        </label>
                    </th>
                    <td><input type="text" name="VOTACAO_ROOT" value="<?php echo $votacao_root;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="VOTACAO_ALTURA">
                            Altura do iframe de votação na capa do site (VOTACAO_ALTURA)
                        </label>
                    </th>
                    <td><input type="text" name="VOTACAO_ALTURA" value="<?php echo $votacao_altura;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Twitter - Capa do site</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_STREAM_USERNAME">
                            Usuário do Twitter para captura dos twits no buzz (TWITTER_STREAM_USERNAME)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_STREAM_USERNAME" value="<?php echo $twitter_stream_username;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_STREAM_PASSWORD">
                            Senha do Twitter (TWITTER_STREAM_PASSWORD)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_STREAM_PASSWORD" value="<?php echo $twitter_stream_password;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_MAYOR_USERNAME">
                            Usuário do Twitter do Governador (TWITTER_MAYOR_USERNAME)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_MAYOR_USERNAME" value="<?php echo $twitter_mayor_username;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="TWITTER_HASH_CABECALHO">
                            Texto de pequisa para twitts que aparecerão na capa do site (TWITTER_HASH_CABECALHO)
                        </label>
                    </th>
                    <td><input type="text" name="TWITTER_HASH_CABECALHO" value="<?php echo $twitter_hash_cabecalho;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Galeria de fotos e vídeo</h2>
            	</td>
                <tr valign="top">
                    <th scope="row">
                        <label for="GALERIAS_DESTACADAS_ID">
                            Id das galerias de fotos destacadas (GALERIAS_DESTACADAS_ID)
                        </label>
                    </th>
                    <td><input type="text" name="GALERIAS_DESTACADAS_ID" value="<?php echo $galerias_destacadas_id;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="VIDEO_PAGINACAO">
                            Nro de vídeos por página (VIDEO_PAGINACAO)
                        </label>
                    </th>
                    <td><input type="text" name="VIDEO_PAGINACAO" value="<?php echo $video_paginacao;?>" size="25" /></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Emails</h2>
            	</th></tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="SMTP">
                            Servidor de emails (SMTP)
                        </label>
                    </th>
                    <td><input type="text" name="SMTP" value="<?php echo $smtp;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="FROM_ADDR">
                            Endereço para respostas dos emails (FROM_ADDR)
                        </label>
                    </th>
                    <td><input type="text" name="FROM_ADDR" value="<?php echo $from_addr;?>" size="25" /></td>
                </tr>

                <tr valign="top"><th colspan=2>
                    <h2>Emails - Mensagens</h2>
                </th></tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="PASSWORD_REMAINDER_SUBJECT">
                            Esqueci a senha, título (PASSWORD_REMAINDER_SUBJECT)
                        </label>
                    </th>
                    <td><input type="text" name="PASSWORD_REMAINDER_SUBJECT" value="<?php echo $password_remainder_subject;?>" size="30" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="PASSWORD_REMAINDER_MSG">
                            Esqueci a senha, corpo (PASSWORD_REMAINDER_MSG)
                        </label>
                    </th>
                    <td><textarea rows="7" cols="55" name="PASSWORD_REMAINDER_MSG"><?php echo $password_remainder_msg;?></textarea></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="WELCOME_SUBJECT">
                            Boas vindas, título (WELCOME_SUBJECT)
                        </label>
                    </th>
                    <td><input type="text" name="WELCOME_SUBJECT" value="<?php echo $welcome_subject;?>" size="30" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="WELCOME_MSG">
                            Boas vindas, corpo (WELCOME_MSG)
                        </label>
                    </th>
                    <td><textarea rows="7" cols="55" name="WELCOME_MSG"><?php echo $welcome_msg;?></textarea></td>
                </tr>


                <tr valign="top">
                    <th scope="row">
                        <label for="COMITE_TO_EMAIL">
                            Comite de Transito, TO email (COMITE_TO_EMAIL)
                        </label>
                    </th>
                    <td><input type="text" name="COMITE_TO_EMAIL" value="<?php echo $comite_to_email;?>" size="30" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="COMITE_SUBJECT">
                            Comite de Transito, título (COMITE_SUBJECT)
                        </label>
                    </th>
                    <td><input type="text" name="COMITE_SUBJECT" value="<?php echo $comite_subject;?>" size="30" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="COMITE_MSG">
                            Comite de Transito, corpo (COMITE_MSG)
                        </label>
                    </th>
                    <td><textarea rows="7" cols="55" name="COMITE_MSG"><?php echo $comite_msg;?></textarea></td>
                </tr>


                <tr valign="top">
                    <th scope="row">
                        <label for="SEGUIROBRA_SUBJECT">
                            Seguir Obra, título (SEGUIROBRA_SUBJECT)
                        </label>
                    </th>
                    <td><input type="text" name="SEGUIROBRA_SUBJECT" value="<?php echo $seguirobra_subject;?>" size="30" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="SEGUIROBRA_MSG">
                            Seguir Obra, corpo (SEGUIROBRA_MSG)
                        </label>
                    </th>
                    <td><textarea rows="7" cols="55" name="SEGUIROBRA_MSG"><?php echo $seguirobra_msg;?></textarea></td>
                </tr>

            	<tr valign="top"><th colspan=2>
            		<h2>Webservice SME</h2>
            	</th></tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="GDOBRA_USUARIO_ADMIN">
                            Código usuário que vai incluir/atualizar o webservice (USUARIO_ADMIN)
                        </label>
                    </th>
                    <td><input type="text" name="GDOBRA_USUARIO_ADMIN" value="<?php echo $gdobra_usuario_admin;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="GDOBRA_APIKEY">
                            Código APIKEY informada no WS SME (GDOBRA_APIKEY)
                        </label>
                    </th>
                    <td><input type="text" name="GDOBRA_APIKEY" value="<?php echo $gdobra_apikey;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="GDOBRA_PRIVATEKEY">
                            Código PRIVATEKEY informada no WS SME (GDOBRA_PRIVATEKEY)
                        </label>
                    </th>
                    <td><input type="text" name="GDOBRA_PRIVATEKEY" value="<?php echo $gdobra_privatekey;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="GDOBRA_PARTURL">
                            Parte da URL informada no WS SME (GDOBRA_PARTURL)
                        </label>
                    </th>
                    <td><input type="text" name="GDOBRA_PARTURL" value="<?php echo $gdobra_parturl;?>" size="25" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="GDOBRA_URL">
                            URL de chamada do WS do SME (GDOBRA_URL)
                        </label>
                    </th>
                    <td><input type="text" name="GDOBRA_URL" value="<?php echo $gdobra_url;?>" size="25" /></td>
                </tr>

            </table>
			<p>
			    <input type="submit" value="Gravar configurações" class="button-primary"/>
			</p>
        </form>
    </div>
<?php
}

function setup_theme_admin_menus() {
    add_submenu_page('themes.php',
        'Front Page Elements', 'GD Config', 'manage_options',
        'gd-config', 'gd_config_settings');
}

// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_theme_admin_menus");


// Add stylesheet
function admin_register_head() {
	$url = dirname( get_bloginfo('stylesheet_url')) . '/gd_config.css';
	echo "<link rel='stylesheet' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');

function gabdig_getconfiguration($args){
    #
    # Método que retorna os dados das configurações gravadas
    # na pagina de config do tema GabDig
    #
    $dados = array(
      'base_url' => get_option("gd_base_url"),
      'date_format' => get_option("gd_date_format"),
      'valor_investimentos' => get_option("gd_valor_investimentos"),
      'pairwise_server' => get_option("gd_pairwise_server"),
      'pairwise_username' => get_option("gd_pairwise_username"),
      'pairwise_password' => get_option("gd_pairwise_password"),
      'twitter_consumer_key' => get_option("gd_twitter_consumer_key"),
      'twitter_consumer_secret' => get_option("gd_twitter_consumer_secret"),
      'facebook_app_id' => get_option("gd_facebook_app_id"),
      'facebook_app_secret' => get_option("gd_facebook_app_secret"),
      'facebook_comment_moderators' => get_option("gd_facebook_comment_moderators"),
      'facebook_comment_url' => get_option("gd_facebook_comment_url"),
      'votacao_url' => get_option("gd_votacao_url"),
      'votacao_root' => get_option("gd_votacao_root"),
      'votacao_altura' => get_option("gd_votacao_altura"),
      'twitter_stream_username' => get_option("gd_twitter_stream_username"),
      'twitter_stream_password' => get_option("gd_twitter_stram_password"),
      'twitter_mayor_username' => get_option("gd_twitter_mayor_username"),
      'twitter_hash_cabecalho' => get_option("gd_twitter_hash_cabecalho"),
      'galerias_destacadas_id' => get_option("gd_galerias_destacadas_id"),
      'video_paginacao' => get_option("gd_video_paginacao"),
      'from_addr' => get_option("gd_from_addr"),
      'smtp' => get_option("gd_smtp"),
      'gdobra_usuario_admin' => get_option("gd_gdobra_usuario_admin"),
      'gdobra_apikey' => get_option("gd_gdobra_apikey"),
      'gdobra_privatekey' => get_option("gd_gdobra_privatekey"),
      'gdobra_parturl' => get_option("gd_gdobra_parturl"),
      'gdobra_url' => get_option("gd_gdobra_url"),
      'password_remainder_subject' => get_option("gd_password_remainder_subject"),
      'password_remainder_msg' => get_option("gd_password_remainder_msg"),
      'welcome_subject' => get_option("gd_welcome_subject"),
      'welcome_msg' => get_option("gd_welcome_msg"),
      'comite_to_email' => get_option("gd_comite_to_email"),
      'comite_subject' => get_option("gd_comite_subject"),
      'comite_msg' => get_option("gd_comite_msg"),
      'seguirobra_subject' => get_option("gd_seguirobra_subject"),
      'seguirobra_msg' => get_option("gd_seguirobra_msg"),
    );
    return $dados;
}

function gabdig_register_methods( $methods ) {
    $methods['gabdig.getConfiguration'] = 'gabdig_getconfiguration';
    return $methods;
}
add_filter( 'xmlrpc_methods', 'gabdig_register_methods' );


?>
