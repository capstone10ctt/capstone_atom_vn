<?php
class ModelBossblogArticles extends Model {
	public function addArticle($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article SET author = '" . $this->db->escape($data['author']) . "', status = '" . (int)$data['status'] . "', allow_comment = '" . (int)$data['allow_comment'] . "', need_approval = '" . (int)$data['need_approval'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
		
		$blog_article_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		}
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_description SET blog_article_id = '" . (int)$blog_article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}
		
		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_store SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_category SET blog_article_id = '" . (int)$blog_article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}
		
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$blog_article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_article_id . "'");
			}
		}
        
        if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$blog_article_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$product_id . "' AND product_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$product_id . "', product_id = '" . (int)$blog_article_id . "'");
			}
		}

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_layout SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
        
        if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_article_id=" . (int)$blog_article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
	}
	
	public function editArticle($blog_article_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET author = '" . $this->db->escape($data['author']) . "', status = '" . (int)$data['status'] . "', allow_comment = '" . (int)$data['allow_comment'] . "', need_approval = '" . (int)$data['need_approval'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = '" . $this->db->escape($data['date_modified']) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_description SET blog_article_id = '" . (int)$blog_article_id . "', language_id = '" . (int)$language_id . "',  name = '" . $this->db->escape($value['name']) . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_store SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
	
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_category SET blog_article_id = '" . (int)$blog_article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE related_id = '" . (int)$blog_article_id . "'");

        if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$blog_article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_article_id . "'");
			}
		}

        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE product_id = '" . (int)$blog_article_id . "'");

        if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$blog_article_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$product_id . "' AND product_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$product_id . "', product_id = '" . (int)$blog_article_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_layout SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id. "'");
        if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_article_id=" . (int)$blog_article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
										
		$this->cache->delete('blog_article');
	}
	
	public function deleteArticle($blog_article_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE related_id = '" . (int)$blog_article_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE product_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id. "'");	
		$this->cache->delete('blog_article');
	}
	
	public function getArticle($blog_article_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id . "') AS keyword FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE ba.blog_article_id = '" . (int)$blog_article_id . "' AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getArticles($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id)";
			
			if (!empty($data['filter_blog_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
			}
					
			$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(bad.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND ba.status = '" . (int)$data['filter_status'] . "'";
			}
					
			if (!empty($data['filter_blog_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
					
					$this->load->model('bossblog/articles');
					
					$categories = $this->model_bossblog_category->getCategories($data['filter_blog_category_id']);
					
					foreach ($categories as $category) {
						$implode_data[] = "bac.blog_category_id = '" . (int)$category['blog_category_id'] . "'";
					}
					
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
				}
			}
			
			$sql .= " GROUP BY ba.blog_article_id";
						
			$sort_data = array(
				'bad.name',
				'ba.status',
				'ba.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY bad.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$article_data = $this->cache->get('article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));
		
			if (!$article_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bad.name ASC");
	
				$article_data = $query->rows;
			
				$this->cache->set('article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $article_data);
			}	
	
			return $article_data;
		}
	}
    
	public function getArticleDescriptions($blog_article_id) {
		$article_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
                'title'            => $result['title'],
				'content'      => $result['content'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}
		
		return $article_description_data;
	}

	public function getArticleStores($blog_article_id) {
		$article_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}
		
		return $article_store_data;
	}

	public function getArticleLayouts($blog_article_id) {
		$article_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $article_layout_data;
	}
		
	public function getArticleCategories($blog_article_id) {
		$article_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_category_data[] = $result['blog_category_id'];
		}

		return $article_category_data;
	}

	public function getArticleRelated($blog_article_id) {
		$article_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}
		
		return $article_related_data;
	}
    
   	public function getBlogProductRelated($blog_article_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['product_id'];
		}
		
		return $product_related_data;
	}
	
	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(DISTINCT ba.blog_article_id) AS total FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id)";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
		}
		 
		$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(bad.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND ba.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "bac.<strong>blog_category_id</strong> = '" . (int)$data['filter_blog_category_id'] . "'";
				
				$this->load->model('bossblog/articles');
				
				$categories = $this->model_bossblog_category->getCategories($data['filter_blog_category_id']);
				
				foreach ($categories as $category) {
					$implode_data[] = "bac.blog_category_id = '" . (int)$category['blog_category_id'] . "'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
			}
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_article_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
    
    public function checkBlogArticle() {       
		$create_blog_article = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article` (`blog_article_id` int(11) NOT NULL auto_increment, `status` tinyint(1) NOT NULL default '0', `allow_comment` tinyint(1) NOT NULL default '0',`author` varchar(255) collate utf8_unicode_ci NOT NULL default '', `need_approval` tinyint(1) NOT NULL default '0', `sort_order` int(11) NOT NULL default '0', `viewed` int(5) NOT NULL default '0', `image` varchar(255) collate utf8_unicode_ci default NULL, `date_added` datetime default NULL, `date_modified` datetime default NULL, PRIMARY KEY  (`blog_article_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article);
		$create_blog_article_descriptions = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article_description` (`blog_article_id` int(11) NOT NULL default '0', `language_id` int(11) NOT NULL default '0', `name` varchar(255) collate utf8_unicode_ci NOT NULL default '',`title` varchar(500) collate utf8_unicode_ci NOT NULL default '', `meta_description` varchar(255) collate utf8_unicode_ci NOT NULL, `meta_keyword` varchar(255) collate utf8_unicode_ci NOT NULL, `content` text collate utf8_unicode_ci NOT NULL, `tag` text collate utf8_unicode_ci NOT NULL, PRIMARY KEY  (`blog_article_id`,`language_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_descriptions);
		$add_fulltext ="ALTER TABLE `" . DB_PREFIX . "blog_article_description` ADD FULLTEXT(`tag`,`content`)";
        $this->db->query($add_fulltext);
        $create_blog_article_category = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article_category` (`blog_article_id` int(11) NOT NULL, `blog_category_id` int(11) NOT NULL, PRIMARY KEY  (`blog_article_id`, `blog_category_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_category);
		$create_blog_article_store = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article_store` (`blog_article_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY  (`blog_article_id`, `store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_store);
        $create_blog_article_layout = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article_layout` (`blog_article_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, `layout_id` int(11) NOT NULL, PRIMARY KEY  (`blog_article_id`, `store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_layout);
        $create_blog_article_related = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_article_related` (`blog_article_id` int(11) NOT NULL, `related_id` int(11) NOT NULL, PRIMARY KEY  (`blog_article_id`, `related_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_related);
        $create_blog_article_product = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_product_related` (`blog_article_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, PRIMARY KEY  (`blog_article_id`, `product_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_product);
	}	
}
?>