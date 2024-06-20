<?php
/*
 * Plugin Name: FAQ Plugin
 * Plugin URI: https://github.com/jgb27/faq-plugin
 * Description: O FAQ Plugin é uma solução poderosa e intuitiva para gerenciar e exibir perguntas frequentes no seu site WordPress. Ideal para sites que buscam fornecer respostas rápidas e organizadas para dúvidas comuns dos usuários, este plugin oferece uma interface simples para a criação, edição e apresentação de FAQs. Com suporte a tipos de post personalizados, shortcode para fácil integração e recursos de interatividade para uma experiência de usuário melhorada, o FAQ Plugin é a ferramenta definitiva para melhorar a comunicação e o suporte ao cliente no seu site.
 * Version: 1.0
 * Author: João Gustavo S. Bispo
 * Author URL: https://www.instagram.com/jgbiispo/
 * License: MIT
*/

/*
LICENÇA MIT

Copyright (c) 2024 João Gustavo Soares Bispo

A permissão é concedida, gratuitamente, a qualquer pessoa que obtenha uma cópia deste software e dos arquivos de documentação associados (o "Software"), para lidar com o Software sem restrições, incluindo, sem limitação, os direitos de usar, copiar, modificar, mesclar, publicar, distribuir, sublicenciar e/ou vender cópias do Software, e permitir às pessoas a quem o Software é fornecido que o façam, sujeito às seguintes condições:

O aviso de copyright acima e este aviso de permissão deverão ser incluídos em todas as cópias ou partes substanciais do Software.

Atribuição — Você deve dar o crédito apropriado, prover um link para o repositório original e indicar se mudanças foram feitas. Você pode fazer isso de qualquer forma razoável, mas não de maneira que sugira que o licenciador endossa você ou seu uso.

O SOFTWARE É FORNECIDO "COMO ESTÁ", SEM GARANTIA DE QUALQUER TIPO, EXPRESSA OU IMPLÍCITA, INCLUINDO, MAS NÃO SE LIMITANDO ÀS GARANTIAS DE COMERCIALIZAÇÃO, ADEQUAÇÃO A UM PROPÓSITO PARTICULAR E NÃO VIOLAÇÃO. EM NENHUMA HIPÓTESE OS AUTORES OU DETENTORES DOS DIREITOS AUTORAIS SERÃO RESPONSÁVEIS POR QUALQUER RECLAMAÇÃO, DANOS OU OUTRA RESPONSABILIDADE, SEJA EM UMA AÇÃO DE CONTRATO, ATO ILÍCITO OU DE OUTRA FORMA, DECORRENTE DE, FORA DE OU EM CONEXÃO COM O SOFTWARE OU O USO OU OUTRAS NEGOCIAÇÕES NO SOFTWARE.
*/

function faq_custom_post_type() {
    // Definindo os rótulos para o Custom Post Type
    $labels = array(
        'name'               => 'FAQs',
        'singular_name'      => 'FAQ',
        'menu_name'          => 'FAQs',
        'name_admin_bar'     => 'FAQ',
        'add_new'            => 'Adicionar Nova',
        'add_new_item'       => 'Adicionar Nova FAQ',
        'new_item'           => 'Nova FAQ',
        'edit_item'          => 'Editar FAQ',
        'view_item'          => 'Ver FAQ',
        'all_items'          => 'Todas as FAQs',
        'search_items'       => 'Procurar FAQs',
        'parent_item_colon'  => 'FAQ Pai:',
        'not_found'          => 'Nenhuma FAQ encontrada.',
        'not_found_in_trash' => 'Nenhuma FAQ encontrada na lixeira.',
    );

    // Definindo os argumentos para o Custom Post Type
    $args = array(
        'labels'             => $labels,
        'public'             => true, // Disponível publicamente
        'publicly_queryable' => true, // Consultável publicamente
        'show_ui'            => true, // Mostrar na interface de administração
        'show_in_menu'       => true, // Mostrar no menu de administração
        'query_var'          => true, // Variável de consulta
        'rewrite'            => array( 'slug' => 'faq' ), // URL amigável
        'capability_type'    => 'post', // Tipo de capacidade
        'has_archive'        => true, // Arquivo disponível
        'hierarchical'       => false, // Sem hierarquia
        'menu_position'      => null, // Posição no menu
        'supports'           => array( 'title', 'editor' ), // Suporte a título e editor
    );

    // Registrando o Custom Post Type
    register_post_type( 'faq', $args );
}

// Hook para inicializar o Custom Post Type
add_action( 'init', 'faq_custom_post_type' );

function faq_shortcode() {
    // Configura os argumentos para consultar as FAQs
    $args = array(
        'post_type' => 'faq',
        'posts_per_page' => -1, // Obter todas as FAQs
    );

    // Executa a consulta
    $faqs = new WP_Query($args);

    // Inicia a variável de saída
    $output = '<div class="faqs">';

    // Loop para exibir cada FAQ
    while ($faqs->have_posts()) {
        $faqs->the_post();
        $output .= '<div class="faq">';
        $output .= '<h3>' . get_the_title() . '</h3>'; // Título da FAQ
        $output .= '<div class="faq-content">' . get_the_content() . '</div>'; // Conteúdo da FAQ
        $output .= '</div>';
    }

    // Finaliza a variável de saída
    $output .= '</div>';

    // Restaura a consulta original
    wp_reset_postdata();

    // Retorna a saída para ser exibida no frontend
    return $output;
}

// Registra o shortcode [faq]
add_shortcode('faq', 'faq_shortcode');

function faq_styles() {
    // Enfileira o estilo do plugin
    wp_enqueue_style('faq-style', plugins_url('faq-style.css', __FILE__));
}

// Hook para enfileirar estilos no frontend
add_action('wp_enqueue_scripts', 'faq_styles');

function faq_scripts() {
    // Enfileira o script do plugin
    wp_enqueue_script('faq-script', plugins_url('faq-script.js', __FILE__), array('jquery'), null, true);
}

// Hook para enfileirar scripts no frontend
add_action('wp_enqueue_scripts', 'faq_scripts');
