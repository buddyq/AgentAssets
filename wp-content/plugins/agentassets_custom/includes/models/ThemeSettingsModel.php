<?php

require_once "SiteSettingsModel.php";

/**
 * Class ThemeSettingsModel
 *
 * @property $header_logo
 * @property $big_title_font_size
 * @property $big_title_font_face
 * @property $big_title_font_style
 * @property $big_title_font_color
 * @property $blog_tagline_font_size
 * @property $blog_tagline_font_face
 * @property $blog_tagline_font_style
 * @property $blog_tagline_font_color
 * @property $main_menu_font_size
 * @property $main_menu_font_face
 * @property $main_menu_font_style
 * @property $main_menu_font_color
 * @property $post_title_font_size
 * @property $post_title_font_face
 * @property $post_title_font_style
 * @property $post_title_font_color
 * @property $content_font_size
 * @property $content_font_face
 * @property $content_font_style
 * @property $content_font_color
 * @property $headings_font_size
 * @property $headings_font_face
 * @property $headings_font_style
 * @property $headings_font_color
 * @property $content_color
 * @property $menu_color
 * @property $custom_menu_color
 * @property $disable_menu_background
 * @property $header_footer_color
 * @property $header_footer_pattern
 * @property $page_background_image
 * @property $page_100_background_image
 * @property $page_background_repeat
 * @property $general_Link_color
 * @property $buttons_1_color
 * @property $buttons_2_color
 * @property $enable_widget_title_black_background
 * @property $disable_widget_background
 */

class ThemeSettingsModel extends SiteSettingsModel {
    const OPTION_PREFIX = 'agentassets_themesettings_';

    protected $_theme_is_private = null;
    protected $_parent_site_id = null;

    protected $_render_config = null;

    /**
     * @param string $className
     * @return ThemeSettingsModel
     */
    public static function model($className = __CLASS__)
    {
        $m = parent::model($className);
        $m->init_theme_info();
        return $m;
    }

    protected function init_theme_info() {
        $theme_system_id = get_option('stylesheet');
        $theme = MedmaThemeManager::findOne('theme_system_id = %s', array($theme_system_id));
        if ($theme) {
            $this->_theme_is_private = ($theme->status == MedmaThemeManager::STATUS_AUTHORIZED);
        }

        if ($this->_theme_is_private) {
            $template_sites = get_blogs_of_user('1');
            foreach($template_sites as $template_site) {
                if ($theme_system_id == get_blog_option($template_site->site_id, 'stylesheet')) {
                    $this->_parent_site_id = $template_site->site_id;
                    break;
                }
            }
        }
    }

    public function currentThemeIsPrivate() {
        return $this->_theme_is_private;
    }

    public function load() {
        $live_option = isset($_GET['customize']) ? json_decode(stripslashes_deep($_GET['customize'])) : array();
        $live_customized = is_array($live_option) ? $live_option : array();
        if (isset($_POST['customized'])) {
            $live_customized = json_decode(stripslashes_deep($_POST['customized']), true);
        }
        $metadata = $this->attributesMetadata();
        foreach($metadata as $attribute => $info) {
            $this->{$attribute} =
                isset($live_customized[$this::OPTION_PREFIX . $attribute]) ?
                    $live_customized[$this::OPTION_PREFIX . $attribute]
                    : (
                        ($this->_theme_is_private) ?
                            get_blog_option($this->_parent_site_id, $this::OPTION_PREFIX . $attribute, isset($info['default']) ? $info['default'] : $this->{$attribute})
                            : get_option($this::OPTION_PREFIX . $attribute, isset($info['default']) ? $info['default'] : $this->{$attribute})
                    );
        }
    }

    public function attributesMetadata()
    {
        return array(
            /*'header_logo' => array(
                'label' => 'Custom logo',
                'type' => 'WP_Customize_Image_Control',
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 1,
            ),*/
            'site_title_face' => array(
                'label' => 'Site Title Font',
                'type' => 'select',
                'google_font_loader' => true,
                'options' => self::fontList(),
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 2,
            ),
            'site_title_size' => array(
                'label' => 'Site Title font Size',
                'type' => 'number',
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 3,
            ),
            'site_title_shadow' => array(
                'label' => 'Site Title Shadow',
                'type' => 'select',
                'default' => 1,
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 4,
            ),
            'top_page_background_color' => array(
                'label' => 'Top of Page Background Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 5,
            ),
            'top_page_background_opacity' => array(
                'label' => 'Top of Page Background Opacity',
                'type' => 'select',
                'default' => '0.1',
                'options' => array(
                    '0.1' => '10%',
                    '0.2' => '20%',
                    '0.3' => '30%',
                    '0.4' => '40%',
                    '0.5' => '50%',
                    '0.55' => '55%',
                    '0.6' => '60%',
                    '0.65' => '65%',
                    '0.7' => '70%',
                    '0.75' => '75%',
                    '0.8' => '80%',
                    '0.85' => '85%',
                    '0.9' => '90%',
                    '0.95' => '95%',
                    '1' => '100%',
                ),
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 6,
            ),
            'site_title_color' => array(
                'label' => 'Site Title Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'header',
                'formIndex' => 7,
            ),
            'content_title_color' => array(
                'label' => 'Content Title Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'body',
                'formIndex' => 8,
            ),
            'navigation_text_color' => array(
                'label' => 'Navigation Text Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'menu',
                'formIndex' => 9,
            ),
            'navigation_hilight_text_color' => array(
                'label' => 'Navigation Hilight Text Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'menu',
                'formIndex' => 10,
            ),
            'site_rest_font_face' => array(
                'label' => 'Select a font for the rest of your site',
                'type' => 'select',
                'google_font_loader' => true,
                'options' => self::fontList(),
                'rules' => array(),
                'section' => 'body',
                'formIndex' => 11,
            ),
            'main_navigation_background_color' => array(
                'label' => 'Main Navigation background color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'menu',
                'formIndex' => 12,
            ),
            'main_navigation_background_hover_color' => array(
                'label' => 'Main Navigation background hover color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'menu',
                'formIndex' => 13,
            ),
            'highlighted_accent_color' => array(
                'label' => 'Highlighted accent color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'body',
                'formIndex' => 14,
            ),
            'main_text_color' => array(
                'label' => 'Main Text Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'body',
                'formIndex' => 15,
            ),
            'footer_text_color' => array(
                'label' => 'Footer Text Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'footer',
                'formIndex' => 16,
            ),
            'footer_link_color' => array(
                'label' => 'Footer Link Color',
                'type' => 'WP_Customize_Color_Control',
                'rules' => array(),
                'section' => 'footer',
                'formIndex' => 17,
            ),
            'always_show_footer' => array(
                'label' => 'Always show footer?',
                'type' => 'select',
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'default' => 1,
                'rules' => array(),
                'section' => 'footer',
                'formIndex' => 18,
            ),
        );
    }

    public static function isOsFont($fontName) {
        return in_array($fontName, array(
            'Arial, Helvetica, sans-serif',
            'Calibri, Candara, Arial, sans-serif',
            'Georgia, serif',
            'Impact, Charcoal, sans-serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Myriad Pro, Myriad, "Liberation Sans", "Nimbus Sans L", "Helvetica Neue", Helvetica, Arial, sans-serif',
            'Palatino Linotype, Book Antiqua, Palatino, serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif',
        ));
    }

    public static function fontList() {
        return array(
            // OS fonts
            'Arial, Helvetica, sans-serif' => 'Arial',
            'Calibri, Candara, Arial, sans-serif' =>'Calibri*',
            'Georgia, serif' => 'Georgia',
            'Impact, Charcoal, sans-serif' => 'Impact',
            'Lucida Sans Unicode, Lucida Grande, sans-serif' => 'Lucida',
            'Myriad Pro, Myriad, "Liberation Sans", "Nimbus Sans L", "Helvetica Neue", Helvetica, Arial, sans-serif' => 'Myriad Pro*',
            'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
            'Tahoma, Geneva, sans-serif' => 'Tahoma',
            'Times New Roman, Times, serif' => 'Times New Roman',
            'Trebuchet MS, Helvetica, sans-serif' => 'Trebuchet MS',
            'Verdana, Geneva, sans-serif'     => 'Verdana',
            // GOOGLE fonts
            "Abel" => "Abel",
            "Abril Fatface" => "Abril Fatface",
            "Aclonica" => "Aclonica",
            "Acme" => "Acme",
            "Actor" => "Actor",
            "Adamina" => "Adamina",
            "Advent Pro" => "Advent Pro",
            "Aguafina Script" => "Aguafina Script",
            "Aladin" => "Aladin",
            "Aldrich" => "Aldrich",
            "Alegreya" => "Alegreya",
            "Alegreya SC" => "Alegreya SC",
            "Alex Brush" => "Alex Brush",
            "Alfa Slab One" => "Alfa Slab One",
            "Alice" => "Alice",
            "Alike" => "Alike",
            "Alike Angular" => "Alike Angular",
            "Allan" => "Allan",
            "Allerta" => "Allerta",
            "Allerta Stencil" => "Allerta Stencil",
            "Allura" => "Allura",
            "Almendra" => "Almendra",
            "Almendra SC" => "Almendra SC",
            "Amaranth" => "Amaranth",
            "Amatic SC" => "Amatic SC",
            "Amethysta" => "Amethysta",
            "Andada" => "Andada",
            "Andika" => "Andika",
            "Angkor" => "Angkor",
            "Annie Use Your Telescope" => "Annie Use Your Telescope",
            "Anonymous Pro" => "Anonymous Pro",
            "Antic" => "Antic",
            "Antic Didone" => "Antic Didone",
            "Antic Slab" => "Antic Slab",
            "Anton" => "Anton",
            "Arapey" => "Arapey",
            "Arbutus" => "Arbutus",
            "Architects Daughter" => "Architects Daughter",
            "Arimo" => "Arimo",
            "Arizonia" => "Arizonia",
            "Armata" => "Armata",
            "Artifika" => "Artifika",
            "Arvo" => "Arvo",
            "Asap" => "Asap",
            "Asset" => "Asset",
            "Astloch" => "Astloch",
            "Asul" => "Asul",
            "Atomic Age" => "Atomic Age",
            "Aubrey" => "Aubrey",
            "Audiowide" => "Audiowide",
            "Average" => "Average",
            "Averia Gruesa Libre" => "Averia Gruesa Libre",
            "Averia Libre" => "Averia Libre",
            "Averia Sans Libre" => "Averia Sans Libre",
            "Averia Serif Libre" => "Averia Serif Libre",
            "Bad Script" => "Bad Script",
            "Balthazar" => "Balthazar",
            "Bangers" => "Bangers",
            "Basic" => "Basic",
            "Battambang" => "Battambang",
            "Baumans" => "Baumans",
            "Bayon" => "Bayon",
            "Belgrano" => "Belgrano",
            "Belleza" => "Belleza",
            "Bentham" => "Bentham",
            "Berkshire Swash" => "Berkshire Swash",
            "Bevan" => "Bevan",
            "Bigshot One" => "Bigshot One",
            "Bilbo" => "Bilbo",
            "Bilbo Swash Caps" => "Bilbo Swash Caps",
            "Bitter" => "Bitter",
            "Black Ops One" => "Black Ops One",
            "Bokor" => "Bokor",
            "Bonbon" => "Bonbon",
            "Boogaloo" => "Boogaloo",
            "Bowlby One" => "Bowlby One",
            "Bowlby One SC" => "Bowlby One SC",
            "Brawler" => "Brawler",
            "Bree Serif" => "Bree Serif",
            "Bubblegum Sans" => "Bubblegum Sans",
            "Buda" => "Buda",
            "Buenard" => "Buenard",
            "Butcherman" => "Butcherman",
            "Butterfly Kids" => "Butterfly Kids",
            "Cabin" => "Cabin",
            "Cabin Condensed" => "Cabin Condensed",
            "Cabin Sketch" => "Cabin Sketch",
            "Caesar Dressing" => "Caesar Dressing",
            "Cagliostro" => "Cagliostro",
            "Calligraffitti" => "Calligraffitti",
            "Cambo" => "Cambo",
            "Candal" => "Candal",
            "Cantarell" => "Cantarell",
            "Cantata One" => "Cantata One",
            "Cardo" => "Cardo",
            "Carme" => "Carme",
            "Carter One" => "Carter One",
            "Caudex" => "Caudex",
            "Cedarville Cursive" => "Cedarville Cursive",
            "Ceviche One" => "Ceviche One",
            "Changa One" => "Changa One",
            "Chango" => "Chango",
            "Chau Philomene One" => "Chau Philomene One",
            "Chelsea Market" => "Chelsea Market",
            "Chenla" => "Chenla",
            "Cherry Cream Soda" => "Cherry Cream Soda",
            "Chewy" => "Chewy",
            "Chicle" => "Chicle",
            "Chivo" => "Chivo",
            "Coda" => "Coda",
            "Coda Caption" => "Coda Caption",
            "Codystar" => "Codystar",
            "Comfortaa" => "Comfortaa",
            "Coming Soon" => "Coming Soon",
            "Concert One" => "Concert One",
            "Condiment" => "Condiment",
            "Content" => "Content",
            "Contrail One" => "Contrail One",
            "Convergence" => "Convergence",
            "Cookie" => "Cookie",
            "Copse" => "Copse",
            "Corben" => "Corben",
            "Cousine" => "Cousine",
            "Coustard" => "Coustard",
            "Covered By Your Grace" => "Covered By Your Grace",
            "Crafty Girls" => "Crafty Girls",
            "Creepster" => "Creepster",
            "Crete Round" => "Crete Round",
            "Crimson Text" => "Crimson Text",
            "Crushed" => "Crushed",
            "Cuprum" => "Cuprum",
            "Cutive" => "Cutive",
            "Damion" => "Damion",
            "Dancing Script" => "Dancing Script",
            "Dangrek" => "Dangrek",
            "Dawning of a New Day" => "Dawning of a New Day",
            "Days One" => "Days One",
            "Delius" => "Delius",
            "Delius Swash Caps" => "Delius Swash Caps",
            "Delius Unicase" => "Delius Unicase",
            "Della Respira" => "Della Respira",
            "Devonshire" => "Devonshire",
            "Didact Gothic" => "Didact Gothic",
            "Diplomata" => "Diplomata",
            "Diplomata SC" => "Diplomata SC",
            "Doppio One" => "Doppio One",
            "Dorsa" => "Dorsa",
            "Dosis" => "Dosis",
            "Dr Sugiyama" => "Dr Sugiyama",
            "Droid Sans" => "Droid Sans",
            "Droid Sans Mono" => "Droid Sans Mono",
            "Droid Serif" => "Droid Serif",
            "Duru Sans" => "Duru Sans",
            "Dynalight" => "Dynalight",
            "EB Garamond" => "EB Garamond",
            "Eater" => "Eater",
            "Economica" => "Economica",
            "Electrolize" => "Electrolize",
            "Emblema One" => "Emblema One",
            "Emilys Candy" => "Emilys Candy",
            "Engagement" => "Engagement",
            "Enriqueta" => "Enriqueta",
            "Erica One" => "Erica One",
            "Esteban" => "Esteban",
            "Euphoria Script" => "Euphoria Script",
            "Ewert" => "Ewert",
            "Exo" => "Exo",
            "Expletus Sans" => "Expletus Sans",
            "Fanwood Text" => "Fanwood Text",
            "Fascinate" => "Fascinate",
            "Fascinate Inline" => "Fascinate Inline",
            "Federant" => "Federant",
            "Federo" => "Federo",
            "Felipa" => "Felipa",
            "Fjord One" => "Fjord One",
            "Flamenco" => "Flamenco",
            "Flavors" => "Flavors",
            "Fondamento" => "Fondamento",
            "Fontdiner Swanky" => "Fontdiner Swanky",
            "Forum" => "Forum",
            "Francois One" => "Francois One",
            "Fredericka the Great" => "Fredericka the Great",
            "Fredoka One" => "Fredoka One",
            "Freehand" => "Freehand",
            "Fresca" => "Fresca",
            "Frijole" => "Frijole",
            "Fugaz One" => "Fugaz One",
            "GFS Didot" => "GFS Didot",
            "GFS Neohellenic" => "GFS Neohellenic",
            "Galdeano" => "Galdeano",
            "Gentium Basic" => "Gentium Basic",
            "Gentium Book Basic" => "Gentium Book Basic",
            "Geo" => "Geo",
            "Geostar" => "Geostar",
            "Geostar Fill" => "Geostar Fill",
            "Germania One" => "Germania One",
            "Give You Glory" => "Give You Glory",
            "Glass Antiqua" => "Glass Antiqua",
            "Glegoo" => "Glegoo",
            "Gloria Hallelujah" => "Gloria Hallelujah",
            "Goblin One" => "Goblin One",
            "Gochi Hand" => "Gochi Hand",
            "Gorditas" => "Gorditas",
            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
            "Graduate" => "Graduate",
            "Gravitas One" => "Gravitas One",
            "Great Vibes" => "Great Vibes",
            "Gruppo" => "Gruppo",
            "Gudea" => "Gudea",
            "Habibi" => "Habibi",
            "Hammersmith One" => "Hammersmith One",
            "Handlee" => "Handlee",
            "Hanuman" => "Hanuman",
            "Happy Monkey" => "Happy Monkey",
            "Henny Penny" => "Henny Penny",
            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
            "Holtwood One SC" => "Holtwood One SC",
            "Homemade Apple" => "Homemade Apple",
            "Homenaje" => "Homenaje",
            "IM Fell DW Pica" => "IM Fell DW Pica",
            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
            "IM Fell Double Pica" => "IM Fell Double Pica",
            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
            "IM Fell English" => "IM Fell English",
            "IM Fell English SC" => "IM Fell English SC",
            "IM Fell French Canon" => "IM Fell French Canon",
            "IM Fell French Canon SC" => "IM Fell French Canon SC",
            "IM Fell Great Primer" => "IM Fell Great Primer",
            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
            "Iceberg" => "Iceberg",
            "Iceland" => "Iceland",
            "Imprima" => "Imprima",
            "Inconsolata" => "Inconsolata",
            "Inder" => "Inder",
            "Indie Flower" => "Indie Flower",
            "Inika" => "Inika",
            "Irish Grover" => "Irish Grover",
            "Istok Web" => "Istok Web",
            "Italiana" => "Italiana",
            "Italianno" => "Italianno",
            "Jim Nightshade" => "Jim Nightshade",
            "Jockey One" => "Jockey One",
            "Jolly Lodger" => "Jolly Lodger",
            "Josefin Sans" => "Josefin Sans",
            "Josefin Slab" => "Josefin Slab",
            "Judson" => "Judson",
            "Julee" => "Julee",
            "Junge" => "Junge",
            "Jura" => "Jura",
            "Just Another Hand" => "Just Another Hand",
            "Just Me Again Down Here" => "Just Me Again Down Here",
            "Kameron" => "Kameron",
            "Karla" => "Karla",
            "Kaushan Script" => "Kaushan Script",
            "Kelly Slab" => "Kelly Slab",
            "Kenia" => "Kenia",
            "Khmer" => "Khmer",
            "Knewave" => "Knewave",
            "Kotta One" => "Kotta One",
            "Koulen" => "Koulen",
            "Kranky" => "Kranky",
            "Kreon" => "Kreon",
            "Kristi" => "Kristi",
            "Krona One" => "Krona One",
            "La Belle Aurore" => "La Belle Aurore",
            "Lancelot" => "Lancelot",
            "Lato" => "Lato",
            "League Script" => "League Script",
            "Leckerli One" => "Leckerli One",
            "Ledger" => "Ledger",
            "Lekton" => "Lekton",
            "Lemon" => "Lemon",
            "Lilita One" => "Lilita One",
            "Limelight" => "Limelight",
            "Linden Hill" => "Linden Hill",
            "Lobster" => "Lobster",
            "Lobster Two" => "Lobster Two",
            "Londrina Outline" => "Londrina Outline",
            "Londrina Shadow" => "Londrina Shadow",
            "Londrina Sketch" => "Londrina Sketch",
            "Londrina Solid" => "Londrina Solid",
            "Lora" => "Lora",
            "Love Ya Like A Sister" => "Love Ya Like A Sister",
            "Loved by the King" => "Loved by the King",
            "Lovers Quarrel" => "Lovers Quarrel",
            "Luckiest Guy" => "Luckiest Guy",
            "Lusitana" => "Lusitana",
            "Lustria" => "Lustria",
            "Macondo" => "Macondo",
            "Macondo Swash Caps" => "Macondo Swash Caps",
            "Magra" => "Magra",
            "Maiden Orange" => "Maiden Orange",
            "Mako" => "Mako",
            "Marck Script" => "Marck Script",
            "Marko One" => "Marko One",
            "Marmelad" => "Marmelad",
            "Marvel" => "Marvel",
            "Mate" => "Mate",
            "Mate SC" => "Mate SC",
            "Maven Pro" => "Maven Pro",
            "Meddon" => "Meddon",
            "MedievalSharp" => "MedievalSharp",
            "Medula One" => "Medula One",
            "Megrim" => "Megrim",
            "Merienda One" => "Merienda One",
            "Merriweather" => "Merriweather",
            "Metal" => "Metal",
            "Metamorphous" => "Metamorphous",
            "Metrophobic" => "Metrophobic",
            "Michroma" => "Michroma",
            "Miltonian" => "Miltonian",
            "Miltonian Tattoo" => "Miltonian Tattoo",
            "Miniver" => "Miniver",
            "Miss Fajardose" => "Miss Fajardose",
            "Modern Antiqua" => "Modern Antiqua",
            "Molengo" => "Molengo",
            "Monofett" => "Monofett",
            "Monoton" => "Monoton",
            "Monsieur La Doulaise" => "Monsieur La Doulaise",
            "Montaga" => "Montaga",
            "Montez" => "Montez",
            "Montserrat" => "Montserrat",
            "Moul" => "Moul",
            "Moulpali" => "Moulpali",
            "Mountains of Christmas" => "Mountains of Christmas",
            "Mr Bedfort" => "Mr Bedfort",
            "Mr Dafoe" => "Mr Dafoe",
            "Mr De Haviland" => "Mr De Haviland",
            "Mrs Saint Delafield" => "Mrs Saint Delafield",
            "Mrs Sheppards" => "Mrs Sheppards",
            "Muli" => "Muli",
            "Mystery Quest" => "Mystery Quest",
            "Neucha" => "Neucha",
            "Neuton" => "Neuton",
            "News Cycle" => "News Cycle",
            "Niconne" => "Niconne",
            "Nixie One" => "Nixie One",
            "Nobile" => "Nobile",
            "Nokora" => "Nokora",
            "Norican" => "Norican",
            "Nosifer" => "Nosifer",
            "Nothing You Could Do" => "Nothing You Could Do",
            "Noticia Text" => "Noticia Text",
            "Nova Cut" => "Nova Cut",
            "Nova Flat" => "Nova Flat",
            "Nova Mono" => "Nova Mono",
            "Nova Oval" => "Nova Oval",
            "Nova Round" => "Nova Round",
            "Nova Script" => "Nova Script",
            "Nova Slim" => "Nova Slim",
            "Nova Square" => "Nova Square",
            "Numans" => "Numans",
            "Nunito" => "Nunito",
            "Odor Mean Chey" => "Odor Mean Chey",
            "Old Standard TT" => "Old Standard TT",
            "Oldenburg" => "Oldenburg",
            "Oleo Script" => "Oleo Script",
            "Open Sans" => "Open Sans",
            "Open Sans Condensed" => "Open Sans Condensed",
            "Orbitron" => "Orbitron",
            "Original Surfer" => "Original Surfer",
            "Oswald" => "Oswald",
            "Over the Rainbow" => "Over the Rainbow",
            "Overlock" => "Overlock",
            "Overlock SC" => "Overlock SC",
            "Ovo" => "Ovo",
            "Oxygen" => "Oxygen",
            "PT Mono" => "PT Mono",
            "PT Sans" => "PT Sans",
            "PT Sans Caption" => "PT Sans Caption",
            "PT Sans Narrow" => "PT Sans Narrow",
            "PT Serif" => "PT Serif",
            "PT Serif Caption" => "PT Serif Caption",
            "Pacifico" => "Pacifico",
            "Parisienne" => "Parisienne",
            "Passero One" => "Passero One",
            "Passion One" => "Passion One",
            "Patrick Hand" => "Patrick Hand",
            "Patua One" => "Patua One",
            "Paytone One" => "Paytone One",
            "Permanent Marker" => "Permanent Marker",
            "Petrona" => "Petrona",
            "Philosopher" => "Philosopher",
            "Piedra" => "Piedra",
            "Pinyon Script" => "Pinyon Script",
            "Plaster" => "Plaster",
            "Play" => "Play",
            "Playball" => "Playball",
            "Playfair Display" => "Playfair Display",
            "Podkova" => "Podkova",
            "Poiret One" => "Poiret One",
            "Poller One" => "Poller One",
            "Poly" => "Poly",
            "Pompiere" => "Pompiere",
            "Pontano Sans" => "Pontano Sans",
            "Port Lligat Sans" => "Port Lligat Sans",
            "Port Lligat Slab" => "Port Lligat Slab",
            "Prata" => "Prata",
            "Preahvihear" => "Preahvihear",
            "Press Start 2P" => "Press Start 2P",
            "Princess Sofia" => "Princess Sofia",
            "Prociono" => "Prociono",
            "Prosto One" => "Prosto One",
            "Puritan" => "Puritan",
            "Quantico" => "Quantico",
            "Quattrocento" => "Quattrocento",
            "Quattrocento Sans" => "Quattrocento Sans",
            "Questrial" => "Questrial",
            "Quicksand" => "Quicksand",
            "Qwigley" => "Qwigley",
            "Radley" => "Radley",
            "Raleway" => "Raleway",
            "Rammetto One" => "Rammetto One",
            "Rancho" => "Rancho",
            "Rationale" => "Rationale",
            "Redressed" => "Redressed",
            "Reenie Beanie" => "Reenie Beanie",
            "Revalia" => "Revalia",
            "Ribeye" => "Ribeye",
            "Ribeye Marrow" => "Ribeye Marrow",
            "Righteous" => "Righteous",
            "Roboto" => "Roboto",
            "Rochester" => "Rochester",
            "Rock Salt" => "Rock Salt",
            "Rokkitt" => "Rokkitt",
            "Ropa Sans" => "Ropa Sans",
            "Rosario" => "Rosario",
            "Rosarivo" => "Rosarivo",
            "Rouge Script" => "Rouge Script",
            "Ruda" => "Ruda",
            "Ruge Boogie" => "Ruge Boogie",
            "Ruluko" => "Ruluko",
            "Ruslan Display" => "Ruslan Display",
            "Russo One" => "Russo One",
            "Ruthie" => "Ruthie",
            "Sail" => "Sail",
            "Salsa" => "Salsa",
            "Sancreek" => "Sancreek",
            "Sansita One" => "Sansita One",
            "Sarina" => "Sarina",
            "Satisfy" => "Satisfy",
            "Schoolbell" => "Schoolbell",
            "Seaweed Script" => "Seaweed Script",
            "Sevillana" => "Sevillana",
            "Shadows Into Light" => "Shadows Into Light",
            "Shadows Into Light Two" => "Shadows Into Light Two",
            "Shanti" => "Shanti",
            "Share" => "Share",
            "Shojumaru" => "Shojumaru",
            "Short Stack" => "Short Stack",
            "Siemreap" => "Siemreap",
            "Sigmar One" => "Sigmar One",
            "Signika" => "Signika",
            "Signika Negative" => "Signika Negative",
            "Simonetta" => "Simonetta",
            "Sirin Stencil" => "Sirin Stencil",
            "Six Caps" => "Six Caps",
            "Slackey" => "Slackey",
            "Smokum" => "Smokum",
            "Smythe" => "Smythe",
            "Sniglet" => "Sniglet",
            "Snippet" => "Snippet",
            "Sofia" => "Sofia",
            "Sonsie One" => "Sonsie One",
            "Sorts Mill Goudy" => "Sorts Mill Goudy",
            "Special Elite" => "Special Elite",
            "Spicy Rice" => "Spicy Rice",
            "Spinnaker" => "Spinnaker",
            "Spirax" => "Spirax",
            "Squada One" => "Squada One",
            "Stardos Stencil" => "Stardos Stencil",
            "Stint Ultra Condensed" => "Stint Ultra Condensed",
            "Stint Ultra Expanded" => "Stint Ultra Expanded",
            "Stoke" => "Stoke",
            "Sue Ellen Francisco" => "Sue Ellen Francisco",
            "Sunshiney" => "Sunshiney",
            "Supermercado One" => "Supermercado One",
            "Suwannaphum" => "Suwannaphum",
            "Swanky and Moo Moo" => "Swanky and Moo Moo",
            "Syncopate" => "Syncopate",
            "Tangerine" => "Tangerine",
            "Taprom" => "Taprom",
            "Telex" => "Telex",
            "Tenor Sans" => "Tenor Sans",
            "The Girl Next Door" => "The Girl Next Door",
            "Tienne" => "Tienne",
            "Tinos" => "Tinos",
            "Titan One" => "Titan One",
            "Trade Winds" => "Trade Winds",
            "Trocchi" => "Trocchi",
            "Trochut" => "Trochut",
            "Trykker" => "Trykker",
            "Tulpen One" => "Tulpen One",
            "Ubuntu" => "Ubuntu",
            "Ubuntu Condensed" => "Ubuntu Condensed",
            "Ubuntu Mono" => "Ubuntu Mono",
            "Ultra" => "Ultra",
            "Uncial Antiqua" => "Uncial Antiqua",
            "UnifrakturCook" => "UnifrakturCook",
            "UnifrakturMaguntia" => "UnifrakturMaguntia",
            "Unkempt" => "Unkempt",
            "Unlock" => "Unlock",
            "Unna" => "Unna",
            "VT323" => "VT323",
            "Varela" => "Varela",
            "Varela Round" => "Varela Round",
            "Vast Shadow" => "Vast Shadow",
            "Vibur" => "Vibur",
            "Vidaloka" => "Vidaloka",
            "Viga" => "Viga",
            "Voces" => "Voces",
            "Volkhov" => "Volkhov",
            "Vollkorn" => "Vollkorn",
            "Voltaire" => "Voltaire",
            "Waiting for the Sunrise" => "Waiting for the Sunrise",
            "Wallpoet" => "Wallpoet",
            "Walter Turncoat" => "Walter Turncoat",
            "Wellfleet" => "Wellfleet",
            "Wire One" => "Wire One",
            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
            "Yellowtail" => "Yellowtail",
            "Yeseva One" => "Yeseva One",
            "Yesteryear" => "Yesteryear",
            "Zeyada" => "Zeyada",
        );
    }

    public function registerCustomizeResources($config, $deps=array()) {
        if (!is_array($config)) {
            throw new Exception('invalid $config type');
        }

        $this->_render_config = $config;
        $customize = '';
        if (isset($_POST['customize'])) {
            $customize = stripslashes_deep($_POST['customize']);
        }


        //add_action('wp_ajax_aa_dynamic_css', array($this, 'ajaxDynamicCss'));
        //wp_enqueue_style('aa-dynamic-css', admin_url('admin-ajax.php') . '?action=aa_dynamic_css&customize='.urlencode($customize), $deps);
        add_action('wp_head', array($this, 'renderHeadDynamicCss'), 99);
        add_action('wp_head', array($this, 'renderFooterScripts'), 99);

        $google_fonts = array();
        foreach ($this->attributesMetadata() as $name => $metadata) {
            if (isset($metadata['google_font_loader']) && $metadata['google_font_loader']) {
                $fontName = $this->{$name};
                if (!self::isOsFont($fontName)) {
                    $google_fonts[] = $fontName;
                }
            }
        }

        foreach($google_fonts as $fontName) {
            wp_enqueue_style('googlefont', "//fonts.googleapis.com/css?family=" . $fontName);
        }
    }

    public function renderFooterScripts() {
        $always_show_footer = isset($this->_render_config['always_show_footer']) ? $this->_render_config['always_show_footer'] : array();
        if ($this->always_show_footer !== 'yes' && isset($always_show_footer['params']) && isset($always_show_footer['params']['button_container_selector'])) {
            ?>
            <script>
                jQuery(document).ready(function() {
                    jQuery('<?php echo $always_show_footer['params']['button_container_selector'];?>').prepend(
                        jQuery('<button class="toggle-footer-button">Hide Agent Info</button>').click(function () {
                            jQuery('<?php echo $always_show_footer['params']['button_container_selector'];?>').toggleClass('hide-footer');

                            var text = jQuery('.toggle-footer-button').text();
                            jQuery('.toggle-footer-button').text(
                                text == "Hide Agent Info" ? "Show Agent Info" : "Hide Agent Info");
                        })
                    )
                });
            </script>
            <?php
        }
    }

    public function loadGoogleFonts() {
        //todo
    }

    public function renderHeadDynamicCss() {
        echo '<style>';
        echo $this->renderDynamicCss();
        echo '</style>';
    }

    public function ajaxDynamicCss() {
        global $wp_customize;
        if (method_exists($wp_customize, 'is_preview') and !is_admin()) {

        } else {
            header('Content-type: text/css');
        }
        echo $this->renderDynamicCss();
        exit;
    }

    public function renderDynamicCss($config = null) {
        if (!is_null($config) && !is_array($config)) {
            throw new Exception('invalid $config type');
        }
        if (is_array($config)) {
            $this->_render_config = $config;
        }
        $dynamicCss = '';
        $fieldsConfig = self::attributesMetadata();

        foreach($this->_render_config as $property => $item) {
            if (!isset($fieldsConfig[$property])) continue;
            if (empty($this->{$property})) continue;

            $params = (isset($item['params']) && is_array($item['params'])) ? $item['params'] : array();
            if (isset($item['options'])) {
                if (isset($item['options'][$this->{$property}]) && !empty($item['options'][$this->{$property}])) {
                    $dynamicCss .= $this->generate_css_rule($item['selector'], $item['options'][$this->{$property}], $params);                }
            } else {
                $dynamicCss .= $this->generate_css_rule($item['selector'], $item['css'], $this->{$property}, $params);
            }
        }
        return $dynamicCss;
    }

    function generate_font_css($selector, $size, $face, $style, $color) {
        $weight = (strpos($style, 'bold') !== false) ? 'bold' : 'normal';
        $fontStyle = (strpos($style, 'italic') !== false) ? 'italic' : 'normal';
        return $selector . ' { '
        . (empty($size) ? '' : ('font-size: '.$size.'px !important; '))
        . (empty($face) ? '' : ('font-family: '.$face.' !important; '))
        . (empty($color) ? '' : ('color: '.$color. ' !important; '))
        . 'font-weight: '.$weight.' !important; '.' font-style: '.$fontStyle.' !important; }'."\n";
    }

    function generate_css_rule($selector, $properties, $value = null, $params = array()) {
        $css_rule = $selector . " {\n";
        foreach($properties as $key => $property) {
            if (!is_null($value)) {
                if (strpos($property, '{rgba}') !== false) {
                    $alpha = '0.7'; // default
                    if (isset($params['alpha']) && isset($this->{$params['alpha']})) {
                        $alpha = $this->{$params['alpha']};
                    }
                    $value = self::hex2rgba($value, $alpha);
                    $property = str_replace('{rgba}', $value, $property);
                } else {
                    $property = str_replace('{value}', $value, $property);
                }
            }
            $css_rule .= $key . ': ' . $property . " !important;\n";
        }
        $css_rule .= "}\n";
        return $css_rule;
    }

    protected static function hex2rgba($color, $opacity = false) {
        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }

}