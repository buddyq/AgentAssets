<?php 

class Add_Sites_Columns {
    public static function init() {
        $class = __CLASS__ ;
        if ( empty( $GLOBALS[ $class ] ) )
            $GLOBALS[ $class ] = new $class;
    }
    public function __construct() {
        add_filter( 'wpmu_blogs_columns', array( $this, 'get_id' ) );
        add_action( 'manage_sites_custom_column', array( $this, 'add_columns' ), 10, 2 );
        add_action( 'manage_blogs_custom_column', array( $this, 'add_columns' ), 10, 2 );
        add_action( 'admin_footer', array( $this, 'add_style' ) );
    }
    public function add_columns( $column_name, $blog_id ) {
        global $wpdb;
        
        if ( 'blog_id' === $column_name ){
            
            echo $blog_id;
            
        } elseif ( 'blog_expire' === $column_name ){
            
            $expiration = get_blog_option( $blog_id, 'expiration' );
            if ( isset( $expiration ) ) {
                echo date( "d-M-Y", $expiration );
            }else{
                echo '-- No Expiration --';
            }
            
            
        } elseif ( 'blog_owner' === $column_name ) {
            // $blogowner_id = get_blog_option( $blog_id, 'blog_owner');
            // $querystring = "SELECT `user_id`
            //     FROM `{$wpdb->prefix}usermeta`
            //     WHERE (meta_key LIKE 'primary_blog' AND meta_value LIKE $blog_id) 
            //     LIMIT 1";
                $blogowner_id = get_blog_option( $blog_id, 'blog_owner');
                // $blogowner_id = $wpdb->get_var($querystring);
                if (isset($blogowner_id)) {
                    
                    $blogowner = get_userdata($blogowner_id);
                    if ($blogowner->display_name != '') {
                        $blogowner = '<strong>'.$blogowner->display_name.'</strong>';
                    }else{
                        $blogowner = '<strong>'.$blogowner->user_login.'</strong>';
                    }
                }else{
                    $blogowner = '<span class="red">-- Not Found --</span>';
                }
                echo $blogowner;
        }
        return $column_name;
    }
    // Add in a column header
    public function get_id( $columns ) {
        $columns['blog_id'] = __('ID');
        //add extra header to table
        $columns['blog_expire'] = __('Expires');
        $columns['blog_owner'] = __('Owner');

        return $columns;
    }
    public function add_style() {
        echo '<style>#blog_id { width:7%; }</style>';
        echo '<style>#owner { width:10%; }</style>';
        echo '<style>.red{color:red};</style>';
    }
}
add_action( 'init', array( 'Add_Sites_Columns', 'init' ) );
