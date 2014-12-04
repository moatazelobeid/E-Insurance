<?php
// table descriptions
// Note: all the tables are named as per the action name
// Admin/Members
define(LOGINTBL,TBLPRE."login");
define(USRTBL,TBLPRE."admin");
define(MEMBERTBL,TBLPRE."members");
define(COMPANYTBL,TBLPRE."company");

define(PAGETBL,TBLPRE."pages");
define(PAGEMENU,TBLPRE."menu");
define(OFLTBL,TBLPRE."office_location");
define(TBLFAQ,TBLPRE."faq");
define(TBLNEWS,TBLPRE."news");
define(GLOBALTBL,TBLPRE."config");
define(FAQADVICE,TBLPRE."advice");
define(FAQADVICECAT,TBLPRE."advice_cat");
define(SOCIALLINKSTBL,TBLPRE."sociallinks");
define(PAGECON,TBLPRE."country");
define(PAGESTA,TBLPRE."state");
define(TESTIMONIAL,TBLPRE."testimonials");
define(TESTIMONIALCAT,TBLPRE."testimonial_cat");

define(CATEGORY,TBLPRE."category");
define(SUBCATEGORY,TBLPRE."subcategory");

define(MEDIATBL,TBLPRE."media");
define(ARTICLETBL,TBLPRE."articles");
define(PROMOTION,TBLPRE."promotion");
define(HOMECONTENTS,TBLPRE."homecontents");
define(NEWSTBL,TBLPRE."news");
define(QUOTETBL,TBLPRE."corporate_quote");
define(CONTACTS,TBLPRE."contacts");
define(TESTIMONIALS,TBLPRE."testimonials");


define(AUTOPOLICY,TBLPRE."auto_policy");
define(HEALTHPOLICY,TBLPRE."health_policy");
define(MALPRACTICEPOLICY,TBLPRE."malpractice_policy"); 
define(TRAVELPOLICY,TBLPRE."travel_policy");
define(ADVERTISEMENT,TBLPRE."advertisement");

define(USERPOLICY,TBLPRE."user_policy"); 
define(USERPOLICYTRAVELLERS,TBLPRE."user_policy_travellers");
define(USERTRAVELPOLICY,TBLPRE."user_travel_policy");
define(PAYMENTS,TBLPRE."payments");
define(USERAUTOPOLICY,TBLPRE."user_auto_policy");
define(USERMALPRACTICEPOLICY,TBLPRE."user_malpractice_policy");

define(USERHEALTHPOLICY,TBLPRE."user_health_policy");
define(USERHEALTHPOLICYMEMBERS,TBLPRE."user_healthpolicy_members");

define(COUNTRY,TBLPRE."country");
define(STATE,TBLPRE."state");
define(OFFERS,TBLPRE."offers");
define(REQUESTQUOTES,TBLPRE."request_quotes");

define(CLAIMTRAVEL,TBLPRE."claims_travel");
define(CLAIMAUTO,TBLPRE."claims_auto");
define(CLAIMMALPRACTICE,TBLPRE."claims_malpractice");
define(CLAIMMEDICAL,TBLPRE."claims_medical");

define(USERTRAVELPOLICYHISTORY,TBLPRE."user_travel_policy_history");
define(USERHEALTHPOLICYHISTORY,TBLPRE."user_health_policy_history");
define(USERMALPRACTICEPOLICYHISTORY,TBLPRE."user_malpractice_policy_history");
define(USERAUTOPOLICYHISTORY,TBLPRE."user_auto_policy_history");

define(RENEWPOLICY,TBLPRE."renew_policy");
define(AGENTPOLICY,TBLPRE."agent_policy");

define(NEWSSUBSCRIBER,TBLPRE."news_letter_subscriber");
define(NEWSLETTER,TBLPRE."newsletter");
define(NOTIFICATION,TBLPRE."notification");
define(EMAILTEMP,TBLPRE."email_text");
define(JOBOPPORTUNITY,TBLPRE."job_oppertunity");

define(SUBMENUTBL,TBLPRE."admin_submenu");
define(ADMMENU,TBLPRE."admin_menu");
define(ACCTBL,TBLPRE."accsetting");
define(ATTACHMENTS,TBLPRE."user_policy_attachments");
define(HOMEMIDIMAGES,TBLPRE."homemid_images");

// New Tables
define(EMPLOYEETBL,TBLPRE."employee");
define(EMPTYPE,TBLPRE."employee_type");
define(AGENTTBL,TBLPRE."agent");
define(USERTBL,TBLPRE."user");
define(DOWNLOADS,TBLPRE."downloads");
define(HOMEBANNER,TBLPRE."homebanners");
define(BRANCHES,TBLPRE."branches");
define(OFFICES,TBLPRE."offices");
define(BUSINESSTYPE,TBLPRE."business_type");
define(VMAKE,TBLPRE."vehicle_make");
define(VMODEL,TBLPRE."vehicle_model");
define(VTYPE,TBLPRE."vehicle_type");
define(POLICIES,TBLPRE."policies");
define(POLICYTYPES,TBLPRE."policy_types");
define(PRODUCTS,TBLPRE."products");
define(PRODUCTATTACHMENTS,TBLPRE."products_attachments");
define(PRODUCTCOVERS,TBLPRE."product_covers");
define(DOCTYPES,TBLPRE."doc_types");
define(PACKAGECOVER,TBLPRE."package_cover");
define(PACKAGE,TBLPRE."package");
define(POLICYQUOTES,TBLPRE."policy_quotes");
define(POLICYMASTER,TBLPRE."policy_master");
define(POLICYMOTOR,TBLPRE."policy_motor");
define(POLICYCOVERS,TBLPRE."policy_covers");
define(POLICYATTACHMENTS,TBLPRE."policy_attachments");
define(POLICYPAYMENTS,TBLPRE."policy_payments");
define(CLAIMMOTOR,TBLPRE."policy_claim_motor");
define(POLICYRENEWAL,TBLPRE."policy_renewal");
define(DRIVERAGE,TBLPRE."driver_age");
define(PACKAGEPRICE,TBLPRE."package_price");
define(AGENCYREPAIR,TBLPRE."agency_repair_cat");
define(MOTORSETTINGS,TBLPRE."motor_settings");
define(POLICYUSE,TBLPRE."policy_use");
define(DEDUCTPKGS,TBLPRE."deduct_packages");

define(LEADSOURCES,TBLPRE."lead_sources");
define(LEADSTATUS,TBLPRE."lead_status");
define(CRMRATINGS,TBLPRE."crm_ratings");
define(OWNERSHIP,TBLPRE."crm_ownership");
define(INDUSTRY,TBLPRE."crm_industry");
define(ACCOUNT_TYPES,TBLPRE."crm_account_types");

define(MEDICALQUOTES,TBLPRE."medical_quotes");
define(NATIONALITY,TBLPRE."nationality");
define(RELATIONSHIPS,TBLPRE."relationships");
define(MEDICAL_PACKAGE,TBLPRE."medical_packages");
define(NETWORKCLASS,TBLPRE."network_class");
define(POLICYMEDICAL,TBLPRE."policy_medical");
define(MEDICAL_INSURED_PERSONS,TBLPRE."medical_insured_persons");
?>
