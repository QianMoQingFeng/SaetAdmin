<?php

declare(strict_types=1);

namespace saet\install;

use PDO;
use saet\Auth;
use saet\Controller;
use saet\Env;
use think\facade\Db;
use think\facade\Config;
use think\facade\Lang;

class Handle extends Controller
{



    protected $view_layout = '../saet/install/layout.html';
    protected $pdoModel = null;
    public function install()
    {
        Lang::load(SAET_PATH . 'install/zh-cn.php', 'zh-cn');
        // Lang::setLangSet('en-us');

        $lock = SAET_PATH . 'install/installed.lock';
        if (file_exists($lock)) error(lang('Already installed'));
        $res = chmod(ROOT_PATH, 0755);
        if ($this->request->isAjax()) {

            $data = $this->request->post();
            $type = $this->request->post('type', 'check');
            $checkRes = $this->checkMysql($data['hostname'], $data['username'], $data['password'], $data['database'], $data['hostport']);
            if ($checkRes && $type == 'check') {
                success('校验通过', [
                    'version' => $checkRes['version()']
                ]);
            }

            // 测试连接
            $database = [
                'database' => $data['database'],
                'username' => $data['username'],
                'password' => $data['password'],
                'hostname' => $data['hostname'],
                'hostport' => $data['hostport'],
                'prefix'   => $data['prefix'],
            ];
            Config::set(['default' => 'tempMysql', 'connections' => ['tempMysql' => array_merge(Config::get('database.connections.mysql'), $database)]], 'database');

            // 导入数据库    
            try {
                $mysql = Db::connect('tempMysql');
                Db::query("select 1");
                $sql = file_get_contents(SAET_PATH . 'install/saetadmin.sql');
                if ($data['prefix'] != 'st_') $sql = str_replace("`st_", '`' . $data['prefix'], $sql);
                $mysql->getPdo()->exec($sql);
            } catch (\Throwable $th) {
                error(lang('Database file installation failed'));
            }
            // 写入env文件
            if (!file_exists(ROOT_PATH . '.env')) {
                file_put_contents(ROOT_PATH . '.env',  file_get_contents(SAET_PATH . 'install/.env.example'));
            }

            // 写入配置
            Env::setEnvGroup('DATABASE', $database);

            // 写入管理员信息
            $res = Auth::register('admin', ['group_ids' => 1, 'username' => $data['admin_username'], 'nickname' => $data['admin_username'], 'password' => $data['admin_password'], 'email' => 'email@saet.io', 'mobile' => '13888888888']);
            if ($res['code'] == 0) {
                error($res['msg']);
            }
            // 写入用户信息

            // 修改入口文件
            $entry_file = $this->request->post('entry_file', 'admin');
            if (file_exists(PUBLIC_PATH . 'admin.php')) {
                rename(PUBLIC_PATH . 'admin.php', "$entry_file.php");
            } else {
                file_put_contents(PUBLIC_PATH . '/' . $entry_file . '.php',  file_get_contents(SAET_PATH . 'install/admin.php'));
            }


            // 生成安装锁
            file_put_contents($lock, 'Install Time : ' . date('Y-m-d H:i:s'));

            success(lang('install successed'));
        }
        $this->assign([
            'file_auth' => substr(sprintf("%o", fileperms(ROOT_PATH)), -4),
            'version' => $this->request->env('SAET_VERSION')
        ]);

        $this->view->config(['view_path' => ROOT_PATH]);
        $this->fetch('/saet/install/install');
    }


    private function checkMysql($hostname,  $username, $password, $database, $hostport = 3306)
    {
        try {
            $this->pdoModel = new PDO("mysql:dbname=$database;host=$hostname;port=$hostport;", $username, $password);
            $pdo = $this->pdoModel->query("select version()");
            $res = $pdo->fetch(PDO::FETCH_ASSOC);
            $mysqlVersion = preg_replace('/[a-z]|[A-Z]|-/', '', $res['version()']);
            if ($mysqlVersion < 5.7) error('数据库版本过低', ['version' => $mysqlVersion]);
            return $res;
        } catch (\Throwable $th) {
            error('数据库错误');
        }
    }
}
