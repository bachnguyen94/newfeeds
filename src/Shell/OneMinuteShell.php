<?php
// * * * * * /var/www/html/webcore/bin/cake OneMinute >> /var/www/html/webcore/tmp/logs/cron.log
namespace App\Shell;
use Cake\Console\Shell;
use Cake\Network\Email\Email;

/**
 * OneMinute shell command.
 */
class OneMinuteShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('EmailStacks');
    }
    
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $this->sendMail();
    }
    
    /**
     * Check email in stack and send to user
     * @throws Exception
     * @return void
     */
    public function sendMail()
    {
        $mails = $this->EmailStacks->find()->where(['sent'=>false]);
        
        $dataResult = [];
        foreach ($mails as $row) 
        {
            $email = new Email('default');
            
            if($email->to($row->email)->subject($row->subject)->send($row->content))
            {
                $ent = $this->EmailStacks->get($row->id);
                $ent->sent = true;
                $this->EmailStacks->save($ent);
            }
        }
    }
}