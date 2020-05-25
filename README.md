后端测试API ROOT：49.233.14.53/git-school/...
## 工程部署
### Apache
```
#安装Apache 2.4.29（来自腾讯云的源）
sudo apt-get install apache2
#这个源部署的apache有点特殊（有可能是版本问题，不了解），配置文件不只有一个httpd.conf文件

#配置监听端口，我总共设置了两个监听端口，80端口为正常访问端口，如果服务器被人日了则禁掉80端口改用23334端口
sudo vim /etc/apache2/ports.conf
Listen 23334
Listen 80

#配置监听端口下的文件管理，这个文件同时管理了错误日志，如果对于不同分支下的日志分开存储可以在这里配置。
sudo vim /etc/apache2/sites-enabled/000-default.conf
#23334和80的设置相同
<VirtualHost *:23334>
#修改DocumentRoot的地址指向/home/ubuntu/htdocs/
DocumentRoot /home/ubuntu/htdocs/
</VirtualHost>

#设置Apache对于/home/ubuntu/htdocs/的操作权限（此处某些网站会直接设置/路径，如果服务器被日就等死）
sudo vim /etc/apache2/apache2.conf
<Directory /home/ubuntu/htdocs>
   Options Indexes FollowSymLinks
   AllowOverride None
   Require all granted
  # Header set Access-Control-Allow-Origin * 
</Directory>

#将/home, /home/ubuntu, /home/ubuntu/htdocs的权限均改为755，apache需要ducomentroot的父级路径都具备访客权限，否则会报403错误。
sudo chmod 755 /home
sudo chmod 755 /home/ubuntu
sudo chmod 755 /home/ubuntu/htdocs

sudo service apache2 restart
```
### PHP
```
#安装PHP 7.2.24

sudo apt-get install php
#apache加载php7.2 module

sudo vim /etc/apache2/apache2.conf
LoadModule php7_module /usr/lib/apache2/modules/libphp7.2.so

sudo service apache2 restart
```
### MYSQL
```
# 安装mysql 5.7
sudo apt-get install mysql-server-5.7
sudo apt-get install mysql-client-core-5.7 
sudo apt-get install mysql-client-5.7 

# mysql 5.7 的版本有点特殊，之前mysql的表存储密码的字段叫做password，这个版本的表存储密码字段叫做authentication_string，所以如果直连mysql修改密码，需要改authentication_string字段，而不是password字段。
# 第二个特殊的点，mysql 5.7好像禁止了root用户以mysql密码的形式登入数据库，只能以sudo mysql -u root的形式登入，所以不要费力气修改root密码了。
sudo mysql -u root
create user aunsmile;
create database aunsmile_db;
update mysql.user set authentication_string = PASSWORD('yourpassword') where user = 'aunsmile';
grant all privileges on aunsmile_db to aunsmile;
#然后之后就可以以mysql -u aunsmile -p的形式登入数据库，具备aunsmile_db的全部操作权限。
```
### THINK_PHP
```
#具体指令记不清楚了
#1. 安装git
#2. 从thinkphp的github上clone下一份（需要额外一份的thinkphp核心驱动，在github上也可以找到）
#3. 将分支切换到5.1分支
#Q1. THINK_PHP可能会出现缺少pdo驱动的情况，需要额外安装，具体解决方案忘记了。
#Q2. 如果报错误500，但数据反馈正常，属于THINK_PHP对于目录操作权限不足，直接chmod 777 目录即可。
```
### 工程部署
```
#懒得做复杂部署了，写了两个脚本做控制逻辑。
#in pull.sh 这个脚本用于免密拉取git数据，git_school作为后端自测目录。
#!/usr/bin/expect

send_user "do pull\r\n"

cd git_school

set timeout 1000
spawn git pull
expect "Username"
send "your username\r"
expect "Password"
send "your password\r"
expect "eof"

send_user "done"
send_user "\r\n"

#in switch.sh 这个脚本用于将后端自测内容发布到前端，school作为前端开发目录
echo "do switch"
rm -rf school
cp -r git_school school 
chmod -R 777 ./school

echo "done"
```

## 资源文件路径
```
新闻图片：49.233.14.53/school/upload/图片日期/图片名称
课程课件: 49.233.14.53/school/resource/课件日期/课件名称
课程视频：49.233.14.53/school/video/视频日期/视频名称
```
## API接口
### 一.用户类：
  #### 1.用户登录接口
  ```
  49.233.14.53/school/public/index.php/index/user/login?username=aaa&password=aaa&type=学生|老师|管理员
  无鉴权
  ```
  字段名称|字段内容
  -|-
  username|用户名
  password|密码
  type|身份
  
  #### 2.用户注册接口
  ```
  49.233.14.53/school/public/index.php/index/user/register?username=aaa&password=bbb&type=学生|老师|管理员 
  无鉴权
  ```
  字段名称|字段内容
  -|-
  username|用户名
  password|密码
  type|身份
  
  #### 3.用户查询接口
  ```
  49.233.14.53/school/public/index.php/index/user/query
  鉴权等级：001
  ```
  
  #### 4.用户删除接口
  ```
  49.233.14.53/school/public/index.php/index/user/remove
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  username|用户名
  
### 二.课程类：

  #### 1.课程搜索接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Search?course_name=C&openid=F6D9C2KpzHIhVsS
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  course_name|被搜索的课程名称
  
  #### 2.课程详情接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Detail?course_id=1&openid=F6D9C2KpzHIhVsS
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  
  #### 3.课程添加接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Insert?openid=snAstbWnSEs789G
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  course_name|课程名称
  grade|学分
  content|课程内容
  teacher_id|老师ID
  process_id|课程名称
  
  #### 4.课程修改接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Update?course_id=1&openid=snAstbWnSEs789G
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  course_name|课程名称
  grade|学分
  content|课程内容
  use_book|使用图书
  position|位置
  teacher_id|老师ID
  process_id|课程名称
  
  #### 5.课程删除接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Remove?course_id=1&openid=snAstbWnSEs789G
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  
  #### 6.课程添加视图接口
  ```
  49.233.14.53/school/public/index.php/Index/Course/Insert_view?openid=snAstbWnSEs789G
  鉴权等级：011
  ```
  
### 三.新闻类：
  #### 1.新闻遍历接口
  ```
  49.233.14.53/school/public/index.php/Index/News/Query?openid=F6D9C2KpzHIhVsS
  鉴权等级：111 
  ```
  
  #### 2.新闻详情接口
  ``` 
  49.233.14.53/school/public/index.php/Index/News/Detail?openid=F6D9C2KpzHIhVsS  
  鉴权等级：111 
  ```
  字段名称|字段内容
  -|-
  new_id|新闻ID
  
  
  #### 3.新闻添加接口
  ```
  49.233.14.53/school/public/index.php/Index/News/Insert?openid=ezSddemyLH3hZDl
  鉴权等级：001 
  ```
  字段名称|字段内容
  -|-
  title|新闻标题
  content|新闻内容
  upload_time|上传时间
  image|图片
	
	
  #### 4.新闻删除接口
  ```
  49.233.14.53/school/public/index.php/Index/News/Remove?openid=ezSddemyLH3hZDl
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  new_id|新闻ID
	
	
  #### 5.新闻修改接口
  ```
  49.233.14.53/school/public/index.php/Index/News/Update?openid=ezSddemyLH3hZDl  
  鉴权等级：001 
  ```
  字段名称|字段内容
  -|-
  new_id|新闻ID
  title|新闻标题
  content|新闻内容
  image|图片
  
  ### 四.专业类
  #### 1.专业搜索接口
  ```
  http://49.233.14.53/git_school/public/index.php/Index/Process/Search?openid=F6D9C2KpzHIhVsS
  鉴权等级：111
  ```
  #### 2.专业详情接口
  ```
  http://49.233.14.53/git_school/public/index.php/Index/Process/Detail?openid=F6D9C2KpzHIhVsS
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  
  #### 3.专业删除接口
  ```
  http://49.233.14.53/git_school/public/index.php/Index/Process/Remove?openid=ezSddemyLH3hZDl
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  
  #### 4.专业修改接口
  ```
  http://49.233.14.53/git_school/public/index.php/Index/Process/Update?openid=ezSddemyLH3hZDl
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  name|专业名称
  content|专业内容
  jobs|职业方向
  
  #### 5.专业添加接口
  ```
  http://49.233.14.53/git_school/public/index.php/Index/Process/Insert?openid=ezSddemyLH3hZDl
  ```
  字段名称|字段内容
  -|-
  name|专业名称
  content|专业内容
  jobs|职业方向
  
  ### 五.专业学期课程接口
  #### 1.查询接口
  ```
  49.233.14.53/school/public/index.php/index/Processcourse/query
  鉴权等级：111
  ```
  #### 2.添加视图接口
  ```
  49.233.14.53/school/public/index.php/index/Processcourse/insert_view
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  
  #### 3.添加接口
  ```
  49.233.14.53/school/public/index.php/index/Processcourse/insert
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  teacher_id|学期索引，应该在闭区间0到7范围内
  course_id|课程ID
  
  #### 4.删除接口
  ```
  49.233.14.53/school/public/index.php/index/Processcourse/remove
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  course_id|课程ID
  
  ### 五.专业教师接口
  
  #### 1.查询接口
  ```
  49.233.14.53/school/public/index.php/index/Processteacher/query
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  
  #### 2.添加视图接口
  ```
  49.233.14.53/school/public/index.php/index/Processteacher/insert_view
  鉴权等级：001
  ```
  
  #### 3.添加接口
  ```
  49.233.14.53/school/public/index.php/index/Processteacher/insert
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  teacher_id|教师ID
  
  #### 4.删除接口
  ```
  49.233.14.53/school/public/index.php/index/Processteacher/remove
  鉴权等级：001
  ```
  字段名称|字段内容
  -|-
  process_id|专业ID
  teacher_id|教师ID
  
  ### 六.课程课件接口
  
  #### 1.查询接口
  ```
  49.233.14.53/school/public/index.php/index/Courseresource/query
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  
  #### 2.添加接口
  ```
  49.233.14.53/school/public/index.php/index/Courseresource/insert
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  name|课件名称
  zip_file|课件资源
  
  #### 3.删除接口
  ```
  49.233.14.53/school/public/index.php/index/Courseresource/remove
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  id|课件ID
  
  ### 六.课程视频接口
  
  #### 1.查询接口
  ```
  49.233.14.53/school/public/index.php/index/Coursevideo/query
  鉴权等级：111
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  
  
  #### 2.添加接口
  ```
  49.233.14.53/school/public/index.php/index/Coursevideo/insert
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  course_id|课程ID
  name|章节名称
  video_file|视频资源
  order_index|排序权重
  
  #### 3.删除接口
  ```
  49.233.14.53/school/public/index.php/index/Coursevideo/remove
  鉴权等级：011
  ```
  字段名称|字段内容
  -|-
  id|视频ID
  
  
## 数据库
### 1.用户表
Field    | Type        | Null | Key | Default | Extra |
-|-|-|-|-|-
username | varchar(20) | NO   | PRI | NULL    |       |
password | varchar(20) | YES  |     | NULL    |       |
openid   | varchar(20) | YES  |     | NULL    |       |
type     | int(11)     | YES  |     | NULL    |       |
### 2.老师表
Field      | Type        | Null | Key | Default | Extra          
-|-|-|-|-|-
teacher_id | int(11)     | NO   | PRI | NULL    | auto_increment 
openid     | varchar(20) | NO   |     | NULL    |                
username   | varchar(30) | YES  |     | NULL    |                
picture    | varchar(20) | YES  |     | NULL    |                

### 3.专业表
 Field      | Type        | Null | Key | Default | Extra          
-|-|-|-|-|-
 process_id | int(11)     | NO   | PRI | NULL    | auto_increment 
 content    | text        | YES  |     | NULL    |                
 jobs       | text        | YES  |     | NULL    |                
 name       | varchar(30) | YES  |     | NULL    |                

### 4.新闻表
| Field       | Type        | Null | Key | Default | Extra          |
-|-|-|-|-|-
| id          | int(11)     | NO   | PRI | NULL    | auto_increment |
| title       | varchar(20) | NO   |     | NULL    |                |
| content     | text        | YES  |     | NULL    |                |
| image       | varchar(20) | YES  |     | NULL    |                |
| upload_time | varchar(20) | YES  |     | NULL    |                |

### 5.课程表
| Field      | Type        | Null | Key | Default | Extra          |
-|-|-|-|-|-
| id         | int(11)     | NO   | PRI | NULL    | auto_increment |
| cname      | varchar(30) | NO   |     | NULL    |                |
| grade      | int(11)     | NO   |     | NULL    |                |
| stu_time   | int(11)     | NO   |     | NULL    |                |
| teacher_id | int(11)     | NO   |     | NULL    |                |
| process_id | int(11)     | NO   |     | NULL    |                |
| content    | text        | YES  |     | NULL    |                |
| use_book   | varchar(50) | YES  |     | NULL    |                |
| position   | varchar(50) | YES  |     | NULL    |                |

### 6.专业学期课程表
Field      | Type    | Null | Key | Default | Extra          
-|-|-|-|-|-
id         | int(11) | NO   | PRI | NULL    | auto_increment 
process_id | int(11) | NO   |     | NULL    |                
term_index | int(11) | NO   |     | NULL    |                
course_id  | int(11) | NO   |     | NULL    |    

### 7.专业教师表
Field      | Type    | Null | Key | Default | Extra          
-|-|-|-|-|-
id         | int(11) | NO   | PRI | NULL    | auto_increment 
process_id | int(11) | NO   |     | NULL    |                
teacher_id | int(11) | NO   |     | NULL    |     

### 8.课程课件表
Field         | Type         | Null | Key | Default | Extra          
-|-|-|-|-|-
id            | int(11)      | NO   | PRI | NULL    | auto_increment 
name          | varchar(30)  | NO   |     | NULL    |                
resource_addr | varchar(100) | NO   |     | NULL    |                
course_id     | int(11)      | NO   |     | NULL    |    

### 9.课程章节（视频）表
Field       | Type         | Null | Key | Default | Extra         
-|-|-|-|-|-
id          | int(11)      | NO   | PRI | NULL    | auto_increment
name        | varchar(30)  | NO   |     | NULL    |               
video_addr  | varchar(100) | NO   |     | NULL    |               
course_id   | int(11)      | NO   |     | NULL    |               
order_index | int(11)      | NO   |     | NULL    |      
