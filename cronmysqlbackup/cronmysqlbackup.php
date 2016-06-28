<?php
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
/**
 * 
 * THIS SOFTWARE IS PROVIDED BY THE AUTHORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * @author	Codex-m <codex_m@yahoo.com>
 * Website: www.php-developer.org  
 * @license	Open source http://www.opensource.org/
 * Title of the project: MySQL database backup using Hosting Cron and PHP
 * Description: This is a script that you can use to regularly backup your MySQL database using hosting cron.
  */
/*
EASY BUT IMPORTANT INSTRUCTIONS, PLEASE READ THIS FIRST: 
ONLY IF YOU ARE REALLY SURE YOU KNOW THESE ALREADY, PROCEED TO #11.

1. Always name this script as cronmysqlbackup.php, do not change the script file name.
2. This PHP script should be inside cronmysqlbackup folder.
3. Do not also change the folder name, it should use the name cronmysqlbackup.
Not changing folder names and files assures that the programming will not be broken which can troublesome to troubleshoot.
if you really need to change, I will not be responsible if the script functionality breaks for some reason.

4. You should upload this folder and script ABOVE the HTML web root. This means above your normal public_html (or www) website directory.

Supposing your server is structured like this:

--home
  --cronmysqlbackup
    |
    ---cronmysqlbackup.php
  ---.htaccess
  --data
  --mail
  --sys
  --tmp
  --logs
  --www
      |
      --yourwebsite.com
            |
            --wp-admin
            --wp-content
            --wp-includes
            --index.php
            --wp-login.php
            --your other wordpress files
            --your other server files
            --.htaccess

Discussion:

data, mail, sys, tmp, logs folder as well as cronmysqlbackup folder are all ABOVE the HTML web root files. These files are NOT accessible using a web browser or the public.
Then the www webroot is where your exact website is found. Some host called your web root folder as html instead of www or even public_html in some web host. It depends on your hosting company.

You can see the full server path of the cronmysqlbackup folder using an SSH client or in your hosting control panel.
For example the full server path to the cronmysqlbackup folder based on the structure given above is:

/home/cronmysqlbackup/

No one can publicly access cronmysqlbackup folder, because it does not belong inside www folder. 

5. About file permissions, the recommended file permissions are as follows:
cronmysqlbackup folder = 755
cronmysqlbackup.php = 755
.htaccess =644

6.Then you will configure your hosting cron to AUTOMATICALLY EXECUTE the PHP script. 
You can refer to the following tutorials:
For those using Cpanel: http://www.php-developer.org/cpanel-crontab-tutorial-using-php-to-execute-cron-jobs/
For other hosting panel: http://www.devshed.com/c/a/Administration/Cron-Job-Tutorial-Crontab-Scheduling-Syntax-and-Script-Example/

7. If you regularly update your website e.g. daily, then you should run backups at least once a week. If you are really concerned you can even configure
to run the cron daily or every 3 days. It depends on your need.

If you are updating weekly then you run the cron once a week.

8. This script will delete automatically delete old database backups and replaced it with new.
9. The time stamp in the MySQL database filename tells when the backup was done.
10. It is recommended for security reasons that you will download the MySQL database to your local computer
using SSH. SSH is free for almost all paid hosting accounts, so it is recommended to enable it and use that for downloading/uploading files.

Or if you are using Amazon S3, you can transfer the backups to the cloud using a PHP script mentioned here: http://net.tutsplus.com/tutorials/php/how-to-use-amazon-s3-php-to-dynamically-store-and-manage-files-with-ease/

11. As a summary, you need to do FIVE things to make this script works:

STEP1. Define your Website MySQL login credentials such as username, password, hostname, database name, etc. below
STEP2. Define the path to your cronmysqlbackup folder as defined by $full_serverpath_to_backup below. You can optionally add other databases aside from your main website database.
STEP3. Decide how many DAYS will you delete the old MySQL files. The unit is in days.
STEP4. Finally Upload the cronmysqlbackup folder with cronmysqlbackup.php and .htaccess to the path above your web root.
STEP5. Enable hosting cron to automatically run these script at intervals you choose e.g. weekly, monthly
The path that you have uploaded should be the same path as what you have declared in $full_serverpath_to_backup 

NOTE: ALL GENERATED MYSQL DATABASE BACKUPS ARE SAVED IN cronmysqlbackup FOLDER.
*/
////////////////////////////////////////////////////////////////////////////
//STEP1. DEFINE YOUR MYSQL DATABASE CONNECTION PARAMETERS HERE
//YOU CAN AS WELL BACKUP UP TO 3 ADDITIONAL DATABASES ASIDE FROM YOUR MAIN WEBSITE DATABASE 
//START WITH THE FIRST ONE and IF YOU WOULD LIKE TO BACKUP MORE THAN ONE MYSQL DATABASE UNCOMMENT TO USE THEM.

$username1 = "qcsasi6_qcsasia";
$password1 = "-obAfZh}#rE?";
$hostname1 = "localhost";
$database1 = "qcsasi6_qcsasiac_qcsasia";

//$username2 = "MYSQL USERNAME 2";
//$password2 = "MYSQL PASSWORD 2";
//$hostname2 = "MYSQL HOSTNAME 2";
//$database2 = "MYSQL DATABASE NAME 2";

//$username3 = "MYSQL USERNAME 3";
//$password3 = "MYSQL PASSWORD 3";
//$hostname3 = "MYSQL HOSTNAME 3";
//$database3 = "MYSQL DATABASE NAME 3";

//$username4 = "MYSQL USERNAME 4";
//$password4 = "MYSQL PASSWORD 4";
//$hostname4 = "MYSQL HOSTNAME 4";
//$database4 = "MYSQL DATABASE NAME 4";

////////////////////////////////////////////////////////////////////////////////////////
//STEP2. DEFINE THE FULL SERVER PATH TO cronmysqlbackup FOLDER
$full_serverpath_to_backup= '/home/qcsasi6/public_html/qcsasia.com/backupdatabase/';
///////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
//STEP3. NUMBER OF DAYS YOU SHOULD LIKE TO DELETE THE OLD MYSQL DATABASE BACKUP.
//TO AVOID CLOGGING THE SERVER WITH OLD BACKUPS, YOU CAN USE THE FOLLOWING RULE:

//IF YOU ARE DOING WEEKLY BACKUPS, THEN 6 DAYS IS FINE.
//FOR DOING BACKUP EVERY TWO WEEKS THEN 13 DAYS IS FINE.
//THE RECOMMENDED RULE IS ONE DAY BEFORE THE CRON INTERVAL
//SO IF THE CRON RUNS EVERY 30 DAYS. 
//SET THE $deleteolddatabase_in_days=29,
$deleteolddatabase_in_days=6;
////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
//STEP4.UPLOAD THIS SCRIPT AND FOLDER TO YOUR HOSTING SERVER ABOUT THE WEB ROOT
///////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
//STEP5. ENABLE THE HOSTING CRON TO AUTOMATICALLY RUN THE BACKUPS/////////////////////
//////////////////////////////////////////////////////////////////////////////////////

//DO NOT EDIT ANYTHING BELOW!!!

$username1 =escapeshellcmd($username1);
$password1 =escapeshellcmd($password1);
$hostname1 =escapeshellcmd($hostname1);
$database1 =escapeshellcmd($database1);
$username2 =escapeshellcmd($username2);
$password2 =escapeshellcmd($password2);
$hostname2 =escapeshellcmd($hostname2);
$database2 =escapeshellcmd($database2);
$username3 =escapeshellcmd($username3);
$password3 =escapeshellcmd($password3);
$hostname3 =escapeshellcmd($hostname3);
$database3 =escapeshellcmd($database3);
$username4 =escapeshellcmd($username4);
$password4 =escapeshellcmd($password4);
$hostname4 =escapeshellcmd($hostname4);
$database4 =escapeshellcmd($database4);

$MySQLbackupfile1= $full_serverpath_to_backup.date("Y-m-d-H-i-s").$database1.'.sql';
$MySQLbackupfile2=$full_serverpath_to_backup.date("Y-m-d-H-i-s").$database2.'.sql';
$MySQLbackupfile3=$full_serverpath_to_backup.date("Y-m-d-H-i-s").$database3.'.sql';
$MySQLbackupfile4=$full_serverpath_to_backup.date("Y-m-d-H-i-s").$database4.'.sql';

$command1 = "mysqldump -u$username1 -p$password1 -h$hostname1 $database1 > $MySQLbackupfile1";
system($command1, $result1);
echo $result1;

if ((!(empty($username2)))&&(!(empty($password2)))&&(!(empty($hostname2)))&&(!(empty($database2))))  {
$command2 = "mysqldump -u$username2 -p$password2 -h$hostname2 $database2 > $MySQLbackupfile2";
system($command2, $result2);
echo $result2;
}

if ((!(empty($username3)))&&(!(empty($password3)))&&(!(empty($hostname3)))&&(!(empty($database3))))  {
$command3 = "mysqldump -u$username3 -p$password3 -h$hostname3 $database3 > $MySQLbackupfile3";
system($command3, $result3);
echo $result3;
}

if ((!(empty($username4)))&&(!(empty($password4)))&&(!(empty($hostname4)))&&(!(empty($database4))))  {
$command4 = "mysqldump -u$username4 -p$password4 -h$hostname4 $database4 > $MySQLbackupfile4";
system($command4, $result4);
echo $result4;
}
$uploadfolder  = $full_serverpath_to_backup;

$fileTypes1      = '*.sql';
$expire_time1    = $deleteolddatabase_in_days*24*60;
foreach (glob($uploadfolder . $fileTypes1) as $Filename1) {
$FileCreationTime1 = filectime($Filename1);
$FileAge1 = time() - $FileCreationTime1;
if ($FileAge1 > ($expire_time1 * 60)){
unlink($Filename1);
}
}
?>