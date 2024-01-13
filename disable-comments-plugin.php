<?php
/**
 * Plugin Name: Disable Comments Plugin
 * Description: Ce plugin désactive les fonctionnalités de commentaires dans WordPress, contribuant à une interface d'administration plus épurée et à une meilleure performance du site. Idéal pour des sites où la section des commentaires n'est pas nécessaire. Conçu spécifiquement pour répondre aux besoins de sites professionnels et personnalisés.
 * Version: 1.0
 * Author: Massamba MBAYE
 * Author URI: https://www.linkedin.com/in/massamba-mbaye/
 * Plugin URI: https://github.com/massamba-mbaye/disable-comments-plugin
 * License: GPL-2.0+
 * Text Domain: disable-comments-plugin
 * Domain Path: /languages/
 */


// Désactiver le support des commentaires pour tous les types de postes
function disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Rediriger toute tentative d'accès à la page des commentaires
function disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

// Supprimer les liens liés aux commentaires dans le back-office
function disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Supprimer les sections des commentaires dans le tableau de bord
function disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

// Désactiver les commentaires dans les widgets
function disable_comments_on_widgets() {
    unregister_widget('WP_Widget_Recent_Comments');
}
add_action('widgets_init', 'disable_comments_on_widgets');

// Supprimer les liens de commentaires du menu d'administration
function disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'disable_comments_admin_bar');
?>
