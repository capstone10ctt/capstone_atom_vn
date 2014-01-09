<?php
class ModelBossthemesBossEditorthemes extends Model
{
    private $color_themes = array(
        'theme1' => array(
            'g_bg_color'                    => 'ffffff',
			'g_text_color'                  => '202020',
            'g_link_normal_color'        	=> '202020',
			
			's_color'						=> '202020',
            
            
            'g_color_1'              		=> 'F46253',
			'g_color_2'						=> '1ba1a5',
			
            'h_bg_color'             		=> 'ffffff',
			'h_color_1_normal'				=> '505050',
			'h_color_2'						=> 'ffffff',
			'h_color_2_bg'					=> 'ef6051',
			'h_color_3'                     => '202020',
			
			
			
			'f_bg_color'                    => '131313',
            'f_color_1'                  	=> 'ffffff',
            'f_color_2'        				=> 'bababa',
            'f_color_3'        				=> '009596',
			
            'm_bg_normal_color'             => 'ffffff',
            'm_text_normal_color'           => '202020',
            'm_text_normal_color_border'    => '202020',
           
           
           
            'mdrop_bg_normal_color'             	=> 'ffffff',
            
            
          
			
			
            'p_name_color'         			=> '202020',
          
            'p_des_color'        			=> '202020',
            'p_price_color'              	=> '202020',
            'p_spec_color'                  => 'A64FB6',
            'p_label_color'                  => 'A64FB6',
            'p_but_normal_color'            => 'ffffff',
            'p_but_hover_color'     		=> '202020',
            'p_text_but_normal_color'       => '202020',
			'p_text_but_hover_color'        => 'ffffff',
			
            't_page_color'                  => '202020',
            't_block_color'         		=> 'ffffff',
            't_block_color_bg_1'         	=> '000000',
            't_block_color_bg_2'         	=> 'ef6051',
            't_block_color_bg_3'         	=> '029498',
            't_bread_normal_color_1'        => '505050',
            't_bread_hover_color_1'         => '202020',
            't_bread_normal_color_2'        => '202020'
        ),
        'theme2' => array(
            'g_bg_color'                    => 'ffffff',
            'g_text_color'                  => '202020',
            'g_link_normal_color'        	=> '202020',
			's_color'						=> '202020',
           
            
            'g_color_1'              		=> '47C7AE',
			'g_color_2'						=> 'E5E2A1',
			
            'h_bg_color'             		=> 'ffffff',
			'h_color_1_normal'				=> '505050',
			'h_color_2'						=> 'ffffff',
			'h_color_2_bg'					=> '46c3ab',
			'h_color_3'                     => '202020',
			
			
			
			'f_bg_color'                    => '202020',
            'f_color_1'                  	=> 'ffffff',
            'f_color_2'        				=> 'bababa',
            'f_color_3'        				=> '02979b',
			
            'm_bg_normal_color'             => 'ffffff',
            'm_text_normal_color'           => '505050',
            'm_text_normal_color_border'    => '',
           
           
           
            'mdrop_bg_normal_color'             	=> 'ffffff',
            
            
           
			
			
            'p_name_color'         			=> '202020',
           
            'p_des_color'        			=> '202020',
            'p_price_color'              	=> '202020',
            'p_spec_color'                  => 'A64FB6',
            'p_label_color'                  => 'A64FB6',
            'p_but_normal_color'            => 'ffffff',
            'p_but_hover_color'     		=> '202020',
            'p_text_but_normal_color'       => '202020',
			'p_text_but_hover_color'        => 'ffffff',
			
            't_page_color'                  => '202020',
            't_block_color'         		=> 'ffffff',
            't_block_color_bg_1'         	=> '000000',
            't_block_color_bg_2'         	=> 'eae7a6',
            't_block_color_bg_3'         	=> '46c3ab',
            't_bread_normal_color_1'        => '505050',
            't_bread_hover_color_1'         => '202020',
            't_bread_normal_color_2'        => '202020'
            
        ),
        'theme3' => array(
            'g_bg_color'                    => 'ffffff',
            'g_text_color'                  => '202020',
            'g_link_normal_color'        	=> '202020',
			's_color'						=> '202020',
           
           
            'g_color_1'              		=> '0350AA',
			'g_color_2'						=> '2C2324',
			
            'h_bg_color'             		=> 'ffffff',
			'h_color_1_normal'				=> '505050',
			'h_color_2'						=> 'ffffff',
			'h_color_2_bg'					=> '034ea7',
			'h_color_3'                     => '202020',
			
			
			
			'f_bg_color'                    => '261e1f',
            'f_color_1'                  	=> 'ffffff',
            'f_color_2'        				=> 'bababa',
            'f_color_3'        				=> '0350aa',
			
            'm_bg_normal_color'             => 'ffffff',
            'm_text_normal_color'           => '2d2425',
            'm_text_normal_color_border'    => '',
           
           
           
            'mdrop_bg_normal_color'             	=> 'ffffff',
            
            

			
			
            'p_name_color'         			=> '202020',
            
            'p_des_color'        			=> '202020',
            'p_price_color'              	=> '202020',
            'p_spec_color'                  => 'A64FB6',
            'p_label_color'                  => 'A64FB6',
            'p_but_normal_color'            => 'ffffff',
            'p_but_hover_color'     		=> '202020',
            'p_text_but_normal_color'       => '202020',
			'p_text_but_hover_color'        => 'ffffff',
			
            't_page_color'                  => '202020',
            't_block_color'         		=> 'ffffff',
            't_block_color_bg_1'         	=> '000000',
            't_block_color_bg_2'         	=> '034ea7',
            't_block_color_bg_3'         	=> '2c2324',
            't_bread_normal_color_1'        => '505050',
            't_bread_hover_color_1'         => '202020',
            't_bread_normal_color_2'        => '202020'
        )
	);
	
	private $background = array(
            'g_bg_image_1'       => 'back_1.png',
            'g_bg_image_2'       => 'back_2.png',
            'g_bg_image_3'       => 'back_3.png',
            'g_bg_image_4'       => 'back_4.png',
            'g_bg_image_5'       => 'back_5.png',
            'g_bg_image_6'       => 'back_6.png',
			'g_bg_image_7'       => 'back_7.png',
            'g_bg_image_8'       => 'back_8.png',
            'g_bg_image_9'       => 'back_9.png',
            'g_bg_image_10'       => 'back_10.png',
            'g_bg_image_11'       => 'back_11.png',
            'g_bg_image_12'       => 'back_12.png',
			'g_bg_image_13'       => 'back_13.png',
            'g_bg_image_14'       => 'back_14.png',
            'g_bg_image_15'       => 'back_15.png'
    );

    private $theme_name;
	

    private $theme_names = array(
		 'theme1' => 'Orange',
        'theme2' => 'Green',
        'theme3' => 'Blue'
    );

    public function setThemeName($theme_name)
    {
        $this->theme_name = $theme_name;
    }

   
    public function getThemeNames()
    {
        return $this->theme_names;
    }

    public function getColorThemes()
    {
        return $this->color_themes;
    }
	
	public function getBackgrounds()
    {
        return $this->background;
    }

}