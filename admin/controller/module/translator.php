<?php
/**
 * ModelTotalHandlingGerman
 *
 * Controller for module GermanLocalisation
 *
 * PHP VERSION 5.3
 *
 * @category File
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License V3
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 * @todo     Create function to import Excel file
 */
/**
 * ModelTotalHandlingGerman
 *
 * Controller for module GermanLocalisation
 *
 * @category Model
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License V3
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */

/**
 * Class translation
 *
 * Class to hold one translation record
 *
 * @category Model
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License V3
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
class Translation
{
    /**
     * Module of the translation (admin or catalog)
	 * @var string
     */
    public $module;

    /**
     * Folder of translation
	 * @var string
     */
    public $folder;

    /**
     * Filename that contains this translation
	 * @var string
     */
    public $file;

    /**
     * Variable for this translation
	 * @var string
     */
    public $variable;

    /**
     * Translation in foreign language
	 * @var string
     */
    public $translation;
}

/**
 * Class Line
 *
 * Class to hold line constants
 *
 * @category Model
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License V3
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
class Line
{
    const UNKNOWN = 0;
    const COMMENT = 1;
    const EMPTYLINE = 2;
    const PHPTAG = 3;
    const COMPLETELINE = 4;
    const INCOMPLETELINESTART = 5;
    const INCOMPLETELINEEND = 6;
}

/**
 * ModelTotalHandlingGerman
 *
 * Controller for module GermanLocalisation
 *
 * @category Model
 * @package  Admin
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-3.0.html GNU Public License V3
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
class ControllerModuleTranslator extends Controller
{
    /**
     * Array of all error messages
     */
    private $_error = array();

    /**
     * Constructor for class ControllerModuleTranslator
     *
     * @param mixed $registry Registry
     *
     * @return void
     */
    function __construct($registry)
    {
        // Call parent constructor
        parent::__construct($registry);

        // Load models and languages
        $this->load->model('localisation/language');
        $this->load->model('localisation/translator');
        $this->load->language('module/translator');

        // Check all variables
        $this->_checkGetVars();

        // Get all translations
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_filter'] = $this->language->get('button_filter');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_excel'] = $this->language->get('button_excel');
        $this->data['button_load_data'] = $this->language->get('button_load_data');
        $this->data['button_check_data'] = $this->language->get('button_check_data');
        $this->data['button_create'] = $this->language->get('button_create');
        $this->data['column_module'] = $this->language->get('column_module');
        $this->data['column_folder'] = $this->language->get('column_folder');
        $this->data['column_file'] = $this->language->get('column_file');
        $this->data['column_variable'] = $this->language->get('column_variable');
        $this->data['column_translation_source']
            = $this->language->get('column_translation_source');
        $this->data['column_translation_destination']
            = $this->language->get('column_translation_destination');
        $this->data['column_action'] = $this->language->get('column_action');
        $this->data['column_message'] = $this->language->get('column_message');
        $this->data['message_duplicate'] = $this->language->get('message_duplicate');
        $this->data['message_empty'] = $this->language->get('message_empty');
        $this->data['message_percent']  = $this->language->get('message_percent');
        $this->data['message_colon'] = $this->language->get('message_colon');
        $this->data['entry_empty'] = $this->language->get('entry_empty');
        $this->data['error_permission'] = $this->language->get('error_permission');
        $this->data['error_no_translations']
            = $this->language->get('error_no_translations');
        $this->data['error_processing'] = $this->language->get('error_processing');
        $this->data['error_warning'] = $this->language->get('error_warning');
        $this->data['text_edit'] = $this->language->get('text_edit');
        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_no_file'] = $this->language->get('text_no_file');
        $this->data['text_total'] = $this->language->get('text_total');
        $this->data['text_success'] = $this->language->get('text_success');
        $this->data['token'] = $this->session->data['token'];
        $this->document->setTitle($this->data['heading_title']);

        // Get URL with sort and order
        $url = $this->_getUrl(true, true);

        // create Breadcrumb
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->data['text_home'],
            'href'      => $this->url->link(
                'common/home', 'token=' . $this->session->data['token'], 'SSL'
            ),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->data['heading_title'],
            'href'      => $this->url->link(
                'module/translator',
                'token=' . $this->session->data['token'] . $url,
                'SSL'
            ),
            'separator' => ' :: '
        );
    }

    /**
     * Display the index page for Controller Module Translator
     *
     * @return void
     */
    public function index()
    {
        // Get all recognized language packages
        $packages = $this->model_localisation_translator->getPackages();

        // Get all maintained languages
        $this->data['languages']
            = $this->model_localisation_language->getLanguages();

        // URL when cancel is clicked
        $this->data['cancel'] = $this->url->link(
            'extension/module', 'token=' . $this->session->data['token'], 'SSL'
        );

        // Prepare array with selection criteria
        $data = array(
            'filter_module' => $this->data['filter_module'],
            'filter_folder' => $this->data['filter_folder'],
            'filter_file' => $this->data['filter_file'],
            'filter_variable' => $this->data['filter_variable'],
            'filter_translation_source' => $this->data['filter_translation_source'],
            'filter_translation_destination'
                => $this->data['filter_translation_destination'],
            'filter_language_source' => $this->data['filter_language_source'],
            'filter_language_destination'
                => $this->data['filter_language_destination'],
            'sort' => $this->data['sort'],
            'order' => $this->data['order'],
            'start' => ((int)$this->data['page'] - 1)
                * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        // Count of all selected translations
        $translation_selected
            = $this->model_localisation_translator->getSelectedTranslationsCount(
                $data
            );

        // Count of all translations
        $translation_total
            = $this->model_localisation_translator->getTotalTranslationsCount(
                $data
            );

        // Get all selected translations
        $results = $this->model_localisation_translator->getTranslations($data);

        // Get the directory
        $directory = $this->_getDirectory();

        // Iterate through all selected translations
        $this->data['translations'] = array();
        foreach ($results as $result) {
            $action = array();

            // Create path to file
            $fileref = $this->_createFileref($directory, $result);

            // Link to edit this file
            $action[] = array(
                'text' => $this->data['text_edit'],
                'href' => $this->url->link(
                    'module/translator/edit',
                    'token=' . $this->session->data['token']
                    . '&translation_file=' . $fileref,
                    'SSL'
                )
            );

            // Data for this translation
            $this->data['translations'][] = array(
                'module'                 => $result['module'],
                'folder'                 => $result['folder'],
                'file'                   => $result['file'],
                'variable'               => $result['variable'],
                'translation_source'     => $result['translation_source'],
                'translation_destination'=> $result['translation_destination'],
                'action'                 => $action
            );
        }

        // Create URL to this page with and without sort/order
        $url_wo_order = $this->_getUrl(false, false);
        if (isset($this->request->get['order'])
            and $this->request->get['order']==='ASC'
        ) {
            $url_w_order = $url_wo_order . '&order=DESC';
        } else {
            $url_w_order = $url_wo_order . '&order=ASC';
        }

        // Link to sort by module
        $this->data['sort_module'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=module' . $url_w_order,
            'SSL'
        );

        // Link to sort by folder
        $this->data['sort_folder'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=folder' . $url_w_order,
            'SSL'
        );

        // Link to sort by file
        $this->data['sort_file'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=file' . $url_w_order,
            'SSL'
        );

        // Link to sort by variable
        $this->data['sort_variable'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=variable' . $url_w_order,
            'SSL'
        );

        // Link to sort by translation source
        $this->data['sort_translation_source'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=translation_source' . $url_w_order,
            'SSL'
        );

        // Link to sort by translation destination
        $this->data['sort_translation_destination'] = $this->url->link(
            'module/translator', 'token=' . $this->session->data['token']
            . '&sort=translation_destination' . $url_w_order,
            'SSL'
        );

        // Link to load data new
        $this->data['loadData'] = $this->url->link(
            'module/translator/loadData',
            'token=' . $this->session->data['token'],
            'SSL'
        );

        // Link to export to Excel
        $this->data['exportExcel'] = $this->url->link(
            'module/translator/exportExcel',
            'token=' . $this->session->data['token'] . $url_w_order,
            'SSL'
        );

        // Link to check data for common errors
        $this->data['checkData'] = $this->url->link(
            'module/translator/checkData',
            'token=' . $this->session->data['token'] . $url_wo_order,
            'SSL'
        );

        // Create overview text
        $this->data['translation_total_overall'] = sprintf(
            $this->data['text_total'],
            $translation_total,
            count($packages)
        );

        // Check if destination language is set
        if (isset($this->data['filter_language_destination'])
            and (int)$this->data['filter_language_destination']!==0
        ) {
            // Yes, then create files is available
            $this->data['createFiles'] = $this->url->link(
                'module/translator/createFiles',
                'token=' . $this->session->data['token'] . $url_wo_order,
                'SSL'
            );
        } else {
            // No, create files is not available
            unset($this->data['button_create']);
            unset($this->data['create_files']);
        }

        // Create pagination
        $pagination = new Pagination();
        $pagination->total = $translation_selected;
        $pagination->page  = $this->data['page'];
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text  = $this->language->get('text_pagination');
        $pagination->url   = $this->url->link(
            'module/translator',
            'token=' . $this->session->data['token'] . $url_w_order . '&page={page}',
            'SSL'
        );
        $this->data['pagination'] = $pagination->render();

        // No translations available so display hint to load data
        if ((int)$translation_total===0) {
            $this->_error['warning'] = $this->data['error_no_translations'];
        }

        // Template with header and footer
        $this->template = 'module/translator.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        // Display warnings
        if (isset($this->_error['warning'])) {
            $this->data['error_warning'] = $this->_error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        // Display success messages
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        // Output index page
        $this->response->setOutput($this->render());
    }

    /**
     * Get the physical directory for the language files
     *
     * @return string
     */
    private function _getDirectory()
    {
        // Get all recognized packages
        $packages = $this->model_localisation_translator->getPackages();

        // Iterate through all packages
        $directory = 'UNKNOWN';
        foreach ($packages as $package) {
            // Check, if language_id is found
            if ((int)$package['language_id']
                ===(int)$this->data['filter_language_destination']
            ) {
                // Remember directory
                $directory=$package['directory'];
            }
        }
        return $directory;
    }

    /**
     * Export the actual selected translations as Excel file
     * uses stripped version of PHPExcel located in system/library
     *
     * @return void
     */
    public function exportExcel()
    {
        // Include PHPExcel found in library folder
        include_once DIR_SYSTEM . 'library'
            . DIRECTORY_SEPARATOR . 'Classes'
            . DIRECTORY_SEPARATOR . 'PHPExcel.php';

        // Start computing data
        $this->index();

        // Create phpExcel object
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Andreas Tangemann")
            ->setLastModifiedBy("Andreas Tangemann")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription(
                "Test document for Office 2007 XLSX, generated using PHP classes."
            )
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        // Create header
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue(
            'A1', $this->data['column_module']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'B1', $this->data['column_folder']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'C1', $this->data['column_file']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'D1', $this->data['column_variable']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'E1', $this->data['column_translation_source']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'F1', $this->data['column_translation_destination']
        );
        $objPHPExcel->getActiveSheet()->setCellValue(
            'G1', 'Hyperlink'
        );

        // Set column width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

        // Same style for all cells
        $objPHPExcel->getActiveSheet()->duplicateStyle(
            $objPHPExcel->getActiveSheet()->getStyle('A1'), 'B1:G1'
        );

        // Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(
            PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE
        );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(
            PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4
        );

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Translation');

        // Get the directory
        $directory = $this->_getDirectory();

        // Get all selected translations
        $results  = $this->model_localisation_translator->getTranslations(
            $this->data
        );
        if ($results) {
            foreach ($results as $key => $result) {
                // Iterate through all translations
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    0, ((int) $key)+2, $result['module']
                );
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    1, ((int) $key)+2, $result['folder']
                );
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    2, ((int) $key)+2, $result['file']
                );
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    3, ((int) $key)+2, $result['variable']
                );
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    4, ((int) $key)+2, $result['translation_source']
                );
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    5, ((int) $key)+2, $result['translation_destination']
                );

                // Create link to file and insert in Excel file
                $fileref = $this->_createFileref($directory, $result);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
                    6, ((int) $key)+2, str_replace('/', '\\', $fileref)
                );
                $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(
                    6, ((int) $key)+2
                )->getHyperlink()->setUrl($fileref);
            }
        }

        // Insert Autofilter
        $objPHPExcel->getActiveSheet()->setAutoFilter('A1:G'.count($results));

        // Save Excel 2007 file
        try {
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->setPreCalculateFormulas(false);
            ob_start();
            $objWriter->save("php://output");
            $excel = ob_get_contents();
            ob_end_clean();
        } catch(Exception $e) {
            die('Error saving Excel file: '.$e->getMessage());
        }

        // Add custom header and print file
        header('Content-Description: File Transfer');
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument'
            . '.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename=translations'
            . date('c') . '.xlsx'
        );
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-re_validate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . strlen($excel));
        echo $excel;

        // so no other output is added to the Excel file
        die();
    }

    /**
     * Check translation data for common problems
     * and report them
     *
     * @todo   find translations with keywords
     * @return html
     */
    public function checkData()
    {
        // Load translations new
        $this->loadData();

        // Get the directory
        $directory = $this->_getDirectory();

        // Reset array that will hold all found problems
        $this->data['messages'] = array();

        // Get all duplicate translations inside one file
        $rows = $this->model_localisation_translator->getDuplicateTranslations(
            $this->data['filter_language_destination']
        );
        foreach ($rows as $row) {
            // Create path to file
            $fileref = $this->_createFileref($directory, $row);

            // Action is to edit the file
            $action = array();
            $action[] = array(
                'text' => $this->data['text_edit'],
                'href' => $this->url->link(
                    'module/translator/edit',
                    'token=' . $this->session->data['token']
                    . '&translation_file=' . $fileref,
                    'SSL'
                )
            );

            // Save message
            $this->data['messages'][] = array(
                'module'                 => $row['module'],
                'folder'                 => $row['folder'],
                'file'                   => $row['file'],
                'variable'               => $row['variable'],
                'translation_source'     => '',
                'translation_destination'=> '',
                'message'                => $this->data['message_duplicate'],
                'action'                 => $action
            );
        }

        // Get all emptry translations
        $rows = $this->model_localisation_translator->getEmptyTranslations(
            $this->data
        );
        foreach ($rows as $row) {
            // Create path to file
            $fileref = $this->_createFileref($directory, $row);

            // Action is to edit the file
            $action = array();
            $action[] = array(
                'text' => $this->data['text_edit'],
                'href' => $this->url->link(
                    'module/translator/edit',
                    'token=' . $this->session->data['token']
                    . '&translation_file=' . $fileref,
                    'SSL'
                )
            );

            // Save message
            $this->data['messages'][] = array(
                'module'                 => $row['module'],
                'folder'                 => $row['folder'],
                'file'                   => $row['file'],
                'variable'               => $row['variable'],
                'translation_source'     => $row['translation_source'],
                'translation_destination'=> $row['translation_destination'],
                'message'                => $this->data['message_empty'],
                'action'                 => $action
            );
        }

        // Get all translations where number of characters is different in source
        // and destination translation for %
        $rows = $this->model_localisation_translator->getTranslationsByCharacter(
            $this->data, '%'
        );
        foreach ($rows as $row) {
            // Create path to file
            $fileref = $this->_createFileref($directory, $row);

            // Action is to edit the file
            $action = array();
            $action[] = array(
                'text' => $this->data['text_edit'],
                'href' => $this->url->link(
                    'module/translator/edit',
                    'token=' . $this->session->data['token']
                    . '&translation_file=' . $fileref,
                    'SSL'
                )
            );

            // Save message
            $this->data['messages'][] = array(
                'module'                 => $row['module'],
                'folder'                 => $row['folder'],
                'file'                   => $row['file'],
                'variable'               => $row['variable'],
                'translation_source'     => $row['translation_source'],
                'translation_destination'=> $row['translation_destination'],
                'message'                => $this->data['message_percent'],
                'action'                 => $action
            );
        }

        // Get all translations where number of characters is different in source
        // and destination translation for :
        $rows = $this->model_localisation_translator->getTranslationsByCharacter(
            $this->data, ':'
        );
        foreach ($rows as $row) {
            // Create path to file
            $fileref = $this->_createFileref($directory, $row);

            // Action is to edit the file
            $action = array();
            $action[] = array(
                'text' => $this->data['text_edit'],
                'href' => $this->url->link(
                    'module/translator/edit',
                    'token=' . $this->session->data['token']
                    . '&translation_file=' . $fileref,
                    'SSL'
                )
            );

            // Save message
            $this->data['messages'][] = array(
                'module'                 => $row['module'],
                'folder'                 => $row['folder'],
                'file'                   => $row['file'],
                'variable'               => $row['variable'],
                'translation_source'     => $row['translation_source'],
                'translation_destination'=> $row['translation_destination'],
                'message'                => $this->data['message_colon'],
                'action'                 => $action
            );
        }

        $this->data['pagination'] = '';

        // Template with header and footer
        $this->template = 'module/translator_check.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        // Display warnings
        if (isset($this->_error['warning'])) {
            $this->data['error_warning'] = $this->_error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        // Display success messages
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        // Output index page
        $this->response->setOutput($this->render());
    }

    /**
     * Check all files in the source language
     * and create missing files in the destination language
     *
     * @return void
     */
    public function createFiles()
    {
        // Fill variables from post
        $this->_checkGetVars();

        // Destination and source language need to be set
        if (isset($this->data['filter_language_destination'])
            and isset($this->data['filter_language_source'])
        ) {
            // Get all files in source language
            $files = $this->model_localisation_translator->getFiles(
                $this->data['filter_language_source']
            );

            // Get the destination directory
            $directory = $this->_getDirectory();

            // Work through all files
            $createdFiles = '';
            foreach ($files as $file) {
                // Create filename
                if ($file['file']==='langpack.php') {
                    // Create fileref for langpack.php
                    // langpack.php is used instead name base file
                    $destlanguage = $this->model_localisation_language->getLanguage(
                        (int)$this->data['filter_language_destination']
                    );
                    $file['file'] = $destlanguage['filename'] . '.php';
                    $fileref = $this->_createFileref($directory, $file);
                    $file['file'] = 'langpack.php';
                } else {
                    // Create fileref for normal file
                    $fileref = $this->_createFileref($directory, $file);
                }

                // Make sure directories exist
                if (!is_dir(dirname($fileref))) {
                    mkdir(dirname($fileref), 0777, true);
                }

                // Check,if file already exists
                if (!file_exists($fileref)) {
                    // Get all variables for this file
                    $variables = $this->model_localisation_translator->getVariables(
                        $file,
                        $this->data['filter_language_source']
                    );

                    // Create file content with all variables
                    $variablestring = '<?php' . PHP_EOL;
                    foreach ($variables as $variable) {
                        $variablestring .= '$_[\'' . $variable['variable']
                            . '\'] = \'\';' . PHP_EOL;
                    }

                    // Create file
                    file_put_contents($fileref, $variablestring);

                    // Save filename
                    $createdFiles .= $fileref . '<br>';
                }
            }

            // Output processing result
            if (empty($createdFiles)) {
                // No files have been created
                echo $this->language->get('error_no_files_created');
            } else {
                // Print created files
                echo $this->language->get('text_files_created') . '<br>';
                echo $createdFiles;
            }
        }
    }

    /**
     * Create the full path for a file in a directory
     *
     * @param string $directory Directory
     * @param string $file      Filename
     *
     * @return string|false
     */
    private function _createFileref($directory, $file)
    {
        $fileref = '';

        // Different methods based on module
        switch ($file['module']) {
        // Catalog module
        case 'catalog':
            if ($file['file']==='langpack.php') {
                // Create file reference for langpack.php
                $fileref = str_replace('admin', 'catalog', DIR_LANGUAGE)
                    . $directory . DIRECTORY_SEPARATOR . $directory . '.php';
            } else {
                // Create file reference for normal file
                $fileref = str_replace('admin', 'catalog', DIR_LANGUAGE)
                    . $directory . DIRECTORY_SEPARATOR
                    . $file['folder'] . DIRECTORY_SEPARATOR . $file['file'];
            }
            break;
        // Admin module
        case 'admin':
            if ($file['file']==='langpack.php') {
                // Create file reference for langpack.php
                $fileref = DIR_LANGUAGE . $directory
                    . DIRECTORY_SEPARATOR . $directory . '.php';
            } else {
                // Create file reference for normal file
                $fileref = DIR_LANGUAGE . $directory
                    . DIRECTORY_SEPARATOR . $file['folder']
                    . DIRECTORY_SEPARATOR . $file['file'];
            }
            break;
        }

        // return false for empty file reference
        if (empty($fileref)) {
            return false;
        }

        return $fileref;
    }

    /**
     * Display the edit page for Controller Module Translator
     *
     * @return void
     */
    public function edit()
    {
        // Get URL of this page
        $url = $this->_getUrl(false, false);

        // additional breadcrumb
        $this->data['breadcrumbs'][] = array(
            'text' => $this->data['text_edit'],
            'href' => $this->url->link(
                'module/translator/edit',
                'token=' . $this->session->data['token'] . $url,
                'SSL'
            ),
            'separator' => ' :: '
        );

        // Check if form has been submitted
        if (($this->request->server['REQUEST_METHOD'] == 'POST')
            && $this->_validate()
        ) {
            // Is filename and file content available?
            if (!empty($this->data['translation_file_content'])
                and !empty($this->data['translation_file'])
            ) {
                // Try to write file
                if (file_put_contents(
                    $this->data['translation_file'],
                    htmlspecialchars_decode($this->data['translation_file_content'])
                )===false) {
                    // Error while writing file
                    $this->_error['warning'] = $this->data['error_save'];
                } else {
                    // File has been written successfully
                    $this->session->data['success'] = $this->data['text_success'];
                }
            }
        }

        // Display warnings
        if (isset($this->_error['warning'])) {
            $this->data['error_warning'] = $this->_error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        // Display success messages
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        // Action is to save the file
        $this->data['action'] = $this->url->link(
            'module/translator/edit',
            'token=' . $this->session->data['token'] . $url,
            'SSL'
        );

        // Read file contents
        if (!empty($this->data['translation_file'])
            && file_exists($this->data['translation_file'])
        ) {
            $this->data['translation_file_content']
                = file_get_contents($this->data['translation_file']);
        }

        // Template with header and footer
        $this->template = 'module/translator_edit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        // Output page
        $this->response->setOutput($this->render());
    }

    /**
     * Check all variables of the actual form
     *
     * @return void
     */
    private function _checkGetVars()
    {
        // Translation file name
        if (isset($this->request->get['translation_file'])) {
            $this->data['translation_file']
                = $this->request->get['translation_file'];
        } else {
            $this->data['translation_file'] = null;
        }

        // Translation file contents
        if (isset($this->request->post['translation_file_content'])) {
            $this->data['translation_file_content']
                = $this->request->post['translation_file_content'];
        } else {
            $this->data['translation_file_content'] = null;
        }

        // Filter module
        if (isset($this->request->get['filter_module'])) {
            $this->data['filter_module'] = $this->request->get['filter_module'];
        } else {
            $this->data['filter_module'] = null;
        }

        // Filter folder
        if (isset($this->request->get['filter_folder'])) {
            $this->data['filter_folder'] = $this->request->get['filter_folder'];
        } else {
            $this->data['filter_folder'] = null;
        }

        // Filter file
        if (isset($this->request->get['filter_file'])) {
            $this->data['filter_file'] = $this->request->get['filter_file'];
        } else {
            $this->data['filter_file'] = null;
        }

        // Filter variable
        if (isset($this->request->get['filter_variable'])) {
            $this->data['filter_variable'] = $this->request->get['filter_variable'];
        } else {
            $this->data['filter_variable'] = null;
        }

        // Filter translation source
        if (isset($this->request->get['filter_translation_source'])) {
            $this->data['filter_translation_source']
                = $this->request->get['filter_translation_source'];
        } else {
            $this->data['filter_translation_source'] = null;
        }

        // Filter translation destination
        if (isset($this->request->get['filter_translation_destination'])) {
            $this->data['filter_translation_destination']
                = $this->request->get['filter_translation_destination'];
        } else {
            $this->data['filter_translation_destination'] = null;
        }

        // Filter language source
        if (isset($this->request->get['filter_language_source'])) {
            $this->data['filter_language_source']
                = $this->request->get['filter_language_source'];
        } else {
            $this->data['filter_language_source'] = null;
        }

        // Filter language destination
        if (isset($this->request->get['filter_language_destination'])) {
            $this->data['filter_language_destination']
                = $this->request->get['filter_language_destination'];
        } else {
            $this->data['filter_language_destination'] = null;
        }

        // Sort
        if (isset($this->request->get['sort'])) {
            $this->data['sort'] = $this->request->get['sort'];
        } else {
            $this->data['sort'] = 'module';
        }

        // Order
        if (isset($this->request->get['order'])) {
            $this->data['order'] = $this->request->get['order'];
        } else {
            $this->data['order'] = 'ASC';
        }

        // Page
        if (isset($this->request->get['page'])) {
            $this->data['page'] = $this->request->get['page'];
        } else {
            $this->data['page'] = 1;
        }
    }

    /**
     * Create url based on form variables
     *
     * @param Boolean $sort  Include sort variable in URL
     * @param Boolean $order Include order variable in URL
     *
     * @return string
     */
    private function _getUrl($sort = false, $order = false)
    {
        $url = '';

        // Filter module
        if (isset($this->request->get['filter_module'])) {
            $url .= '&filter_module=' . $this->request->get['filter_module'];
        }

        // Filter folder
        if (isset($this->request->get['filter_folder'])) {
            $url .= '&filter_folder=' . $this->request->get['filter_folder'];
        }

        // Filter file
        if (isset($this->request->get['filter_file'])) {
            $url .= '&filter_file=' . $this->request->get['filter_file'];
        }

        // Filter variable
        if (isset($this->request->get['filter_variable'])) {
            $url .= '&filter_variable=' . $this->request->get['filter_variable'];
        }

        // Filter translation source
        if (isset($this->request->get['filter_translation_source'])) {
            $url .= '&filter_translation_source='
                . $this->request->get['filter_translation_source'];
        }

        // Filter translation destination
        if (isset($this->request->get['filter_translation_destination'])) {
            $url .= '&filter_translation_destination='
                . $this->request->get['filter_translation_destination'];
        }

        // Filter language source
        if (isset($this->request->get['filter_language_source'])) {
            $url .= '&filter_language_source='
                . $this->request->get['filter_language_source'];
        }

        // Filter language destination
        if (isset($this->request->get['filter_language_destination'])) {
            $url .= '&filter_language_destination='
                . $this->request->get['filter_language_destination'];
        }

        // Translation file
        if (isset($this->request->get['translation_file'])) {
            $url .= '&translation_file=' . $this->request->get['translation_file'];
        }

        // Sort, extra check
        if (isset($this->request->get['sort']) && $sort===true) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        // Order, extra check
        if (isset($this->request->get['order']) && $order===true) {
            $url .= '&order=' . $this->request->get['order'];
        }

        return $url;
    }

    /**
     * Install module translator
     *
     * @return void
     */
    public function install()
    {
        // Create table packages
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tr_packages` ("
            . "package_id integer(11) NOT NULL AUTO_INCREMENT"
            . ", description varchar(30) NOT NULL"
            . ", `language_id` int(11) NOT NULL"
            . ", version varchar(30) NOT NULL"
            . ", directory varchar(30) NOT NULL"
            . ", PRIMARY KEY (package_id)) "
            . "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $query = $this->db->query($sql);

        // Create table translations
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tr_translations` ("
            . "translation_id integer(11) NOT NULL AUTO_INCREMENT"
            . ", package_id integer(11) NOT NULL"
            . ", module varchar(10) NOT NULL"
            . ", folder varchar(30) NOT NULL"
            . ", file varchar(30) NOT NULL"
            . ", variable varchar(40) NOT NULL"
            . ", translation varchar(500) NOT NULL"
            . ", PRIMARY KEY (translation_id)) "
            . "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $query = $this->db->query($sql);
    }

    /**
     * Delete all translation records and process all translation files
     *
     * @return void
     */
    public function loadData()
    {
        // Delete all translations
        $sql = "DELETE FROM `" . DB_PREFIX . "tr_translations`";
        $query = $this->db->query($sql);

        // Delete all packages
        $sql = "DELETE FROM `" . DB_PREFIX . "tr_packages`";
        $query = $this->db->query($sql);

        // Get all languages maintained in opencart
        $languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $entry) {
            // Save language as package
            $sql = "INSERT INTO `" . DB_PREFIX . "tr_packages` ("
                . "`description`, `language_id`, `version`, `directory`) "
                . "VALUES ('" . $entry['name'] . ' ' . VERSION . "'"
                . ", '"                 . $entry['language_id'] . "'"
                . ", '" . VERSION . "', '" . $entry['directory'] . "')";
            $query = $this->db->query($sql);
            $this->id = $this->db->getLastId();

            // Process admin folder
            $this->_processFolder(DIR_LANGUAGE . $entry['directory']);

            // Process catalog folder
            $this->_processFolder(
                str_replace('admin', 'catalog', DIR_LANGUAGE) . $entry['directory']
            );
        }

        // Set message and create page
        $this->session->data['success'] = $this->data['error_warning'];
        $this->index();
    }

    /**
     * Uninstall module translator
     *
     * @return void
     */
    public function uninstall()
    {
        // Delete table packages
        $sql = "DROP TABLE `" . DB_PREFIX . "tr_packages`;";
        $query = $this->db->query($sql);

        // Delete table translations
        $sql = "DROP TABLE `" . DB_PREFIX . "tr_translations`;";
        $query = $this->db->query($sql);
    }

    /**
     * Process a folder recursively and search for translation files
     *
     * @param string $path Folder to be processed
     *
     * @return void
     */
    private function _processFolder($path)
    {
        // Quit if folder does not exist
        if (!file_exists($path)) {
            return;
        }

        // Quit if folder is empty
        $directory = scandir($path);
        if ($directory===false) {
            return;
        }

        // Process all entries
        foreach ($directory as $entry) {
            if (is_dir($path . '/' . $entry) && $entry!=='.'&&$entry!=='..') {
                // Process subfolders recursively
                $this->_processFolder($path . '/' . $entry);
            } else {
                if (stripos($entry, '.php')!==false) {
                    // Process all php files
                    $this->_processFile($path . '/' . $entry);
                }
            };
        }
    }

    /**
     * Process all lines in a language file
     *
     * @param string $filename The name of the file that will be processed
     *
     * @return void
     */
    private function _processFile($filename)
    {
        // Init variables
        $line = "";
        $translation = "";
        $variable = "";
        $linetype = 0;

        // Replace Backslash in filename with slash
        $newfile = str_replace(chr(92), '/', $filename);

        // Explode folders
        $filearray = explode('/', $newfile);

        // Get position of language folder
        $position = (int)array_search('language', $filearray, true);
        if ($position===false) {
            // no language folder, something is wrong
            return;
        }

        // Determine if this file is a normal one or the language base file based
        // on the position of the language folder
        $position = (int)$position;
        $module = $filearray[$position-1];
        $language = $filearray[$position + 1];
        if ((count($filearray)-$position)>3) {
            // normal file
            $folder = $filearray[$position + 2];
            $file = $filearray[$position + 3];
        } else {
            // language base file -> change filename
            $folder = '';
            $file = 'langpack.php';
        }

        // Process content of file
        $content = file($filename);
        $actualTranslation = new translation();
        foreach ($content as $line) {
            // Determine line type and process accordingly
            $linetype = $this->_determineLineType($line);
            If ($linetype === Line::PHPTAG) {
                // Ignore php tag
                Continue;
            }

            If ($linetype === Line::EMPTYLINE) {
                // Ignore empty lines
                Continue;
            }

            If ($linetype === Line::UNKNOWN) {
                // Add unknown lines to the translation
                $translation += $line;
            }

            If ($linetype === Line::COMMENT) {
                // Ignore commented lines
                Continue;
            }

            If ($linetype === Line::COMPLETELINE) {
                // Process complete translation in one line
                $varstart = strpos($line, '$_[\'') + 4;
                $varend = strpos($line, '\'', $varstart);
                If ($varend <= $varstart) {
                    // No variable found
                    $this->log->write(
                        sprintf($this->data['error_processing'], $line, $filename)
                    );
                    continue;
                }

                $transstart = strpos($line, '\'', $varend + 1) + 1;
                $transend = strrpos($line, '\'');
                If ($transend <= $transstart) {
                    // No translation found
                    $this->log->write(
                        sprintf($this->data['error_processing'], $line, $filename)
                    );
                    continue;
                }

                // Save translation and insert in database
                $actualTranslation->module = $module;
                $actualTranslation->language = $language;
                $actualTranslation->folder = $folder;
                $actualTranslation->file = $file;
                $actualTranslation->variable = substr(
                    $line, $varstart, $varend - $varstart
                );
                $actualTranslation->translation
                    = substr($line, $transstart, $transend - $transstart);
                $this->_insertLine($actualTranslation);
                Continue;
            }

            If ($linetype === Line::INCOMPLETELINESTART) {
                // Process translation started but not completed in this line
                $varstart = strpos($line, '$_[\'') + 4;
                $varend = strpos($line, '\'', $varstart);
                If ($varend<=$varstart) {
                    // No variable found
                    $this->log->write(
                        sprintf($this->data['error_processing'], $line, $filename)
                    );
                    Continue;
                }

                $variable = substr($line, $varstart, $varend - $varstart);
                $transstart = strpos($line, '\'', $varend + 1) + 1;
                If ($transstart===false) {
                    // No translation found
                    $this->log->write(
                        sprintf($this->data['error_processing'], $line, $filename)
                    );
                    Continue;
                }

                // Save part of the translation
                $translation = substr($line, $transstart);
                Continue;
            }

            If ($linetype === Line::INCOMPLETELINEEND) {
                // Process translation started in another line
                // but completed in this line
                $transend = strrpos($line, '\'');
                if ($transend === false) {
                    // No translation found
                    $this->log->write(
                        sprintf($this->data['error_processing'], $line, $filename)
                    );
                    Continue;
                }

                // Save complete translation
                $actualTranslation->module = $module;
                $actualTranslation->language = $language;
                $actualTranslation->folder = $folder;
                $actualTranslation->file = $file;
                $actualTranslation->variable = $variable;
                $actualTranslation->translation
                    = $translation + substr($line, 0, $transend);
                $this->_insertLine($actualTranslation);
                Continue;
            }
        }
    }

    /**
     * Insert a new translation in the translation database
     *
     * @param Translation $newLine Array of translation
     *
     * @return query
     */
    private function _insertLine($newLine)
    {
        $sql = "INSERT INTO `" . DB_PREFIX . "tr_translations` ("
            . "package_id, module, folder, file, variable, translation) VALUES ("
            . $this->id . ", '" . $newLine->module . "'"
            . ", '" . $newLine->folder . "', "
            . "'" . basename($newLine->file) . "', "
            . "'" . $newLine->variable . "', "
            . "'" . $this->db->escape($newLine->translation) . "');";
        $query = $this->db->query($sql);
        return $query;
    }

    /**
     * Check which type of line this is
     *
     * @param string $line Line from translation file
     *
     * @return string
     */
    Private Function _determineLineType($line)
    {
        $line = trim($line);

        // Determine empty line
        If (empty($line)) {
            Return Line::EMPTYLINE;
        }

        // Determine comment
        If (strpos($line, '//')===0) {
            Return Line::COMMENT;
        }

        // Determine php tag
        If (trim($line)==='<?php' || trim($line)==='?>') {
            Return Line::PHPTAG;
        }

        // Determine real translations
        If (stristr($line, '$_[\'')!==false) {
            If (substr($line, strlen($line) - strlen(';')) === ';') {
                // Line contains one full translation
                Return Line::COMPLETELINE;
            } Else {
                // Line contains a started translation
                Return Line::INCOMPLETELINESTART;
            }
        } else {
            If (substr($line, strlen($line) - strlen(';')) === ';') {
                // Line contains a completed translation
                Return Line::INCOMPLETELINEEND;
            }
        }

        // So this line type is unknown
        Return Line::UNKNOWN;
    }

    /**
     * Validate access to this module
     *
     * @return  boolean
     */
    private function _validate()
    {
        if (!$this->user->hasPermission('modify', 'module/translator')) {
            $this->_error['warning'] = $this->data['error_permission'];
        }

        if (!$this->_error) {
            return true;
        } else {
            return false;
        }
    }
}
?>
