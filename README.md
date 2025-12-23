# Emby Panel
---
### 🖼️ 面板总览

**注册界面**  
<img src="https://raw.githubusercontent.com/dannisjay/emby-panel/refs/heads/main/images/%E4%B8%BB%E9%A1%B5.png" alt="注册页面" width="48%" />

**功能管理**  
<img src="https://raw.githubusercontent.com/dannisjay/emby-panel/refs/heads/main/images/%E7%AE%A1%E7%90%86%E5%90%8E%E5%8F%B0.png" alt="用户管理" width="48%" />



## 部署教程
### 目录结构
```bash
/opt/emby-panel
├── config.php
├── docker-compose.yml
```
### 1. config.php
#### 模版
```bash
https://raw.githubusercontent.com/dannisjay/emby-panel/refs/heads/main/config.php
```

### 2. docker-compose.yml
```bash
services:
  emby-panel:
    image: dannis1514/emby-panel:beta
    container_name: emby-panel
    ports:
      - "8080:80"
    volumes:
      - ./config.php:/var/www/html/config.php:ro
      - ./data:/data
      - ./logs:/logs
    environment:
      TZ: Asia/Shanghai
    restart: unless-stopped
```
### 3. 访问面板
#### 浏览器打开
```bash
http://你的服务器IP:8080
```
