<?php
/**
 * ModelLocalisationTranslator
 *
 * PHP VERSION 5.3
 *
 * @category File
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
/**
 * ModelLocalisationTranslator
 *
 * Model for LocalisationTranslator
 *
 * @category Model
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
class ModelLocalisationTranslator extends Model
{
    /**
     * Create SQL statement
     *
     * @param Array $data Array of data
     *
     * @return string
     */
    private function _createSQL($data = array())
    {
		$sql = '';
        if (isset($data['filter_module']) && !empty($data['filter_module'])) {
            $sql .= " AND lower(module) like lower('%"
                . $data['filter_module'] . "%')";
        }

        if (isset($data['filter_folder']) && !empty($data['filter_folder'])) {
            $sql .= " AND lower(folder) like lower('%"
                . $data['filter_folder'] . "%')";
        }

        if (isset($data['filter_file']) && !empty($data['filter_file'])) {
            $sql .= " AND lower(file) like lower('%" . $data['filter_file'] . "%')";
        }

        if (isset($data['filter_variable']) && !empty($data['filter_variable'])) {
            $sql .= " AND lower(variable) like lower('%"
                . $data['filter_variable'] . "%')";
        }

        if (isset($data['filter_translation_source'])
            && !empty($data['filter_translation_source'])
        ) {
            $sql .= " AND lower(translation_source) like lower('%"
                . $data['filter_translation_source'] . "%')";
        }

        if (isset($data['filter_translation_destination'])
            && !empty($data['filter_translation_destination'])
        ) {
            $sql .= " AND lower(translation_destination) like lower('%"
                . $data['filter_translation_destination'] . "%')";
        }

		return $sql;
	}
	
    /**
     * Returns all selected translations
     *
     * @param Array $data Array of data
     *
     * @return rows
     */
    public function getTranslations($data = array())
    {
        $sql = "select * from ("
            . "SELECT module, folder, file, variable"
            . ", max(translation_source) as translation_source"
            . ", max(translation_destination) as translation_destination "
            . "FROM ("
            . "select module, folder, file, variable"
            . ", translation as translation_source, NULL as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_source'] . " "
            . "UNION ALL "
            . "select module, folder, file, variable, NULL as translation_source"
            . ", translation as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and " . "pa.language_id=" . (int)$data['filter_language_destination']
            . ") translation_inner "
            . "group by module, folder, file, variable) translation_outer "
            . "WHERE 1=1 ";
		
		$sql .= $this->_createSQL($data);

        $sort_data = array(
            'module',
            'folder',
            'file',
            'variable',
            'translation_source',
            'translation_destination'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY module";
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
    }

    /**
     * Returns all variables with empty translations
     *
     * @param Array $data Array of data
     *
     * @return rows
     */
    public function getEmptyTranslations($data = array())
    {
        $sql = "select * from ("
            . "SELECT module, folder, file, variable"
            . ", max(translation_source) as translation_source"
            . ", max(translation_destination) as translation_destination "
            . "FROM ("
            . "select module, folder, file, variable"
            . ", translation as translation_source, NULL as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_source'] . " "
            . "UNION ALL "
            . "select module, folder, file, variable, NULL as translation_source"
            . ", translation as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_destination']
            . ") translation_inner "
            . " group by module, folder, file, variable"
            . ") translation_outer "
            . "WHERE length(trim(translation_source))=0 "
            . "or length(trim(translation_destination))=0 "
            . "or translation_source is null "
            . "or translation_destination is null";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * Returns all translations containing the given character
     *
     * @param Array $data      Array of data
     * @param char  $character Character to search for
     *
     * @return rows
     */
    public function getTranslationsByCharacter($data, $character)
    {
        $sql = "select * from ("
            . "SELECT module, folder, file, variable"
            . ", max(translation_source) as translation_source"
            . ", max(translation_destination) as translation_destination "
            . "FROM ("
            . "select module, folder, file, variable"
            . ", translation as translation_source,NULL as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_source'] . " "
            . "UNION ALL "
            . "select module, folder, file, variable, NULL as translation_source"
            . ", translation as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_destination']
            . ") translation_inner "
            . "group by module, folder, file, variable"
            . ") translation_outer "
            . "WHERE length(translation_source)-"
            . "length(replace(translation_source,'" . $character . "', ''))<>"
            . "length(translation_destination)-length(replace("
            . "translation_destination,'" . $character . "', ''))";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * Calculate total of all selected translations
     *
     * @param Array $data Array of data
     *
     * @return int total
     */
    public function getSelectedTranslationsCount($data = array())
    {
        $sql = "SELECT count(*) as total FROM ("
            . "select * from ("
            . "SELECT module, folder, file, variable, "
            . "max(translation_source) as translation_source"
            . ", max(translation_destination) as translation_destination "
            . "FROM ("
            . "select module, folder, file, variable, "
            . "translation as translation_source, NULL as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_source'] . " "
            . "UNION ALL "
            . "select module, folder, file, variable, NULL as translation_source"
            . ", translation as translation_destination "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$data['filter_language_destination']
            . ") translation_join "
            . "group by module, folder, file, variable"
            . ") translation_inner "
            . ") " . "translation_outer WHERE 1=1 ";

		$sql . $this->_createSQL($data);
			
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    /**
     * Returns all duplicate translations inside one file
     *
     * @param int $language ID of language
     *
     * @return rows
     */
    public function getDuplicateTranslations($language = 0)
    {
        $sql = "select module, folder, file, variable, count(*) as sum "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$language . " "
            . "group by module, folder, file, variable having sum>1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * Calculate total of all translations
     *
     * @return int total
     */
    public function getTotalTranslationsCount()
    {
        $sql = "SELECT count(*) as total FROM `" . DB_PREFIX . "tr_translations`";
        $query = $this->db->query($sql);
        return (int)$query->row['total'];
    }

    /**
     * Return all filenames used in a specific language
     *
     * @param int $language ID of language
     *
     * @return rows
     */
    public function getFiles($language = 0)
    {
        $sql = "select module, folder, file "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$language . " "
            . "GROUP BY module, folder, file";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * Return all variables used in a specific module,
     * folder, file and language
     *
     * @param Translation $file     Array of fileinfo
     * @param int         $language Number of source language
     *
     * @return rows
     */
    public function getVariables($file = array(), $language = 0)
    {
        $sql = "select variable "
            . "from `" . DB_PREFIX . "tr_translations` tr"
            . ", `" . DB_PREFIX . "tr_packages` pa "
            . "WHERE tr.package_id=pa.package_id "
            . "and pa.language_id=" . (int)$language . " "
            . "AND tr.module='" . $file['module'] . "' "
            . "AND tr.folder='" . $file['folder'] . "' "
            . "AND tr.file='" . $file['file'] . "' "
            . "order by variable";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * Return all found packages
     *
     * @return rows
     */
    public function getPackages()
    {
        $sql = "select * from `" . DB_PREFIX . "tr_packages` pa";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
?>