<?php

namespace App\Controllers;

use App\Libraries\FileBase64;
use App\Models\MAcara;
use App\Models\MAcaraSub;
use App\Models\MBiodata;
use App\Models\MUndangan;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['OptionHelpers', 'query'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    protected $fileBase64;
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        helper('auth');

        $this->fileBase64 = new FileBase64(); // create library

        $this->MUser = new UserModel();
        $this->group = new GroupModel();
        $this->permissions = new PermissionModel();
        $this->MAcara = new MAcara();
        $this->MAcaraSub = new MAcaraSub();
        $this->MUndangan = new MUndangan();
        $this->MBiodata = new MBiodata();
    }
}
