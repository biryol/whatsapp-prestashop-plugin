# whatsapp-prestashop-plugin

### How to install module

### 1. By Module Manager
    * Download the files from git repo
    * Rename Download zip file to tochat_whatsapp.zip
    * Go to Shop Backend > Modules > Module Manger
    * Top Right Corner, you see Upload a module. Click here and select your file
    * the module will be installed on your shop.
    
### 2. By FTP
    * Connect to server using FTP client.
    * Switch to Directory modules in prestashop root directory
    * Create a directory with name "tochat_whatsapp"
    * upload all the files which downloaded from repo inside "tochatwhatsapp"
    * Go to Shop Backend > Modules > Module Catalog
    * here you see the module Tochat Whatsapp 
    * Click Install.
    
### Module Configuration
    Admin > Modules > Module Manager > Find module Tochat Whatsapp > Configure

### Trendyol API Integration

This module now includes a basic Trendyol order sync integration.

1. Open module configuration in PrestaShop admin panel.
2. Fill in `Supplier ID`, `API Key`, `API Secret`, and `Base URL` under **Trendyol API Integration**.
3. Save settings and use **Sync Trendyol Orders** button for manual sync.
4. You can also run the module cron URL; Trendyol sync runs together with existing jobs.

Synced order logs are stored in the module message log table with type `Trendyol Sync`.
