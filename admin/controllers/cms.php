<?php
    // MODULE 6: CMS NEWS & SEO ACTIONS ROUTER
    // ==========================================
    if ($page === 'cms') {
        // News & SEO Actions
        if (in_array($action, ['create_post', 'edit_post', 'delete_post', 'save_seo'])) {
            include __DIR__ . '/cms/news.php';
        }
        // Homepage actions
        elseif (in_array($action, ['save_settings', 'save_s5_privileges', 'save_s6_reasons', 'save_s8_offers', 'save_homepage_faqs', 'save_s7_tradein', 'save_s9_dual_actions'])) {
            include __DIR__ . '/cms/homepage.php';
        }
        // About actions
        elseif ($action === 'save_about') {
            include __DIR__ . '/cms/about.php';
        }
        // Installment actions
        elseif ($action === 'save_installment_info') {
            include __DIR__ . '/cms/installment.php';
        }
        // Pricelist actions
        elseif ($action === 'save_pricelist_info') {
            include __DIR__ . '/cms/pricelist.php';
        }
        // Forms config actions
        elseif ($action === 'save_forms_config') {
            include __DIR__ . '/cms/forms.php';
        }
    }




