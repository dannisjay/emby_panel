# Emby Panel
---
### 🖼️ 面板总览

**核心界面**  
<img src="https://raw.githubusercontent.com/dannisjay/emby_panel/refs/heads/main/images/%E6%B3%A8%E5%86%8C%E9%A1%B5%E9%9D%A2.png" alt="注册页面" width="48%" />
<img src="https://raw.githubusercontent.com/dannisjay/emby_panel/refs/heads/main/images/%E7%AE%A1%E7%90%86%E7%95%8C%E9%9D%A2.png" alt="管理主界面" width="48%" />

**功能管理**  
<img src="https://raw.githubusercontent.com/dannisjay/emby_panel/refs/heads/main/images/%E7%94%A8%E6%88%B7%E7%AE%A1%E7%90%86.png" alt="用户管理" width="32%" />
<img src="https://raw.githubusercontent.com/dannisjay/emby_panel/refs/heads/main/images/%E9%82%80%E8%AF%B7%E7%A0%81.png" alt="邀请码管理" width="32%" />
<img src="https://raw.githubusercontent.com/dannisjay/emby_panel/refs/heads/main/images/%E5%AA%92%E4%BD%93%E5%BA%93%E7%AE%A1%E7%90%86.png" alt="媒体库管理" width="32%" />



## 部署教程

### 1. 下载面板文件
```bash
sudo bash -c 'cd /opt && curl -sL https://github.com/dannisjay/emby_panel/releases/download/v1.0/emby_panel.tar.gz | tar -xz'
```
##### 进入/opt/emby_panel, 修改配置 config.php

### 2. 安装 Apache2 和 PHP 环境
```bash
sudo apt install apache2 php libapache2-mod-php -y
```
### 3. 修改 Apache 端口
```bash
sudo nano /etc/apache2/ports.conf
```
#### 将 Listen 80 改为 Listen 9096
##### 保存退出：Ctrl+O → 回车 → Ctrl+X

### 4.修改虚拟主机端口
```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```
#### 把最上面的 <VirtualHost *:80> 改为<VirtualHost *:9096>

#### 找到 
```bash
DocumentRoot /var/www/html
```
#### 改为 
```bash
DocumentRoot /opt/emby_panel
```
##### 保存退出：Ctrl+O → 回车 → Ctrl+X

### 5. 设置文件权限
```bash
sudo chown -R www-data:www-data /opt/emby_panel
```
```bash
sudo chmod -R 755 /opt/emby_panel
```
```bash
sudo chmod 666 /opt/emby_panel/invite_codes.json
```
### 6. 测试配置并重启 Apache
```bash
sudo apache2ctl configtest
```
```bash
sudo systemctl restart apache2
```
```bash
sudo systemctl enable apache2
```
### 7. 访问面板
#### 浏览器打开下面地址
```bash
http://你的服务器IP:9096
```
