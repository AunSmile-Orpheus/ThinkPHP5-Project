后端测试API ROOT：49.233.14.53/git-school/...

## 资源文件路径
```
新闻图片：49.233.14.53/school/upload/图片日期/图片名称
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
