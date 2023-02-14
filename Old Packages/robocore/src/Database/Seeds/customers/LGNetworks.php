<?php

namespace database\seeds\customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;



class LGNetworks extends Seeder
{
//To quickly generate a UUID just do

//Uuid::generate()

    public function run(){
        $now=time();

        $property_id='e3bc51a6-2923-4b5f-a4da-30cb5385b232';
        $property_root_url="https://www.lgnetworksinc.com";

        $pages=[
            ['id'=>'3f9cceb6-86fd-4af8-9797-1aa71cae2243','url'=>urlencode($property_root_url.'/about'),'property_id'=>$property_id,'name'=>'about','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f1d9eaff-8898-4046-80d5-120c4569006d','url'=>urlencode($property_root_url.'/active-directory-consulting-firm'),'property_id'=>$property_id,'name'=>'active-directory-consulting-firm','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'ba11ff14-d309-4650-8924-dc763d2b1650','url'=>urlencode($property_root_url.'/back-up-solutions-and-implementation'),'property_id'=>$property_id,'name'=>'back-up-solutions-and-implementation','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f7ccb19d-d746-4c5c-84a0-f1688fe9c24d','url'=>urlencode($property_root_url.'/backupDisasterAndRecovery'),'property_id'=>$property_id,'name'=>'backupDisasterAndRecovery','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'9703e0ec-37af-4dd1-9384-cada098569c8','url'=>urlencode($property_root_url.'/businessContinuityPlanning'),'property_id'=>$property_id,'name'=>'businessContinuityPlanning','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3c602200-e321-4cec-8c38-a5edf1991c91','url'=>urlencode($property_root_url.'/certified-network-security-expert-consultants'),'property_id'=>$property_id,'name'=>'certified-network-security-expert-consultants','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'0688416a-0eb8-4cd8-9545-8ffa7ae20edf','url'=>urlencode($property_root_url.'/cloudServices'),'property_id'=>$property_id,'name'=>'cloudServices','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'4c6050ac-308f-41c2-95c0-da5b28f55bb0','url'=>urlencode($property_root_url.'/colocation-services-dallas'),'property_id'=>$property_id,'name'=>'colocation-services-dallas','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'de629876-ade2-44c4-9ae6-583e88029f36','url'=>urlencode($property_root_url.'/computer-support-dallas'),'property_id'=>$property_id,'name'=>'computer-support-dallas','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'1430ac17-963a-45e5-94e1-a184f40e0aea','url'=>urlencode($property_root_url.'/contact-us'),'property_id'=>$property_id,'name'=>'contact-us','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'1b0ed8ef-1403-4b2d-9dd9-2f564ecb66ac','url'=>urlencode($property_root_url.'/corporate_ethics_policy'),'property_id'=>$property_id,'name'=>'corporate_ethics_policy','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'640b1217-02a3-42c5-845e-011cce8320d8','url'=>urlencode($property_root_url.'/data-backup-storage-and-recovery'),'property_id'=>$property_id,'name'=>'data-backup-storage-and-recovery','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'77ae1224-fd28-475d-a351-2b67bc0257d9','url'=>urlencode($property_root_url.'/emailAndSpamProtection'),'property_id'=>$property_id,'name'=>'emailAndSpamProtection','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'b7f0a4c0-2f53-4857-9c33-56a0a48234d9','url'=>urlencode($property_root_url.'/exchange-server-best-practices'),'property_id'=>$property_id,'name'=>'exchange-server-best-practices','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'20d4d082-17cc-48ac-9586-5f2db506d8d5','url'=>urlencode($property_root_url.'/exchange-server-health-check'),'property_id'=>$property_id,'name'=>'exchange-server-health-check','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f26da39b-8492-4d0e-bdf9-96b7940152ac','url'=>urlencode($property_root_url.'/expert-internet-information-server-iis-consulting'),'property_id'=>$property_id,'name'=>'expert-internet-information-server-iis-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'c06eee63-5b3d-493d-93b0-d8bc343d5e52','url'=>urlencode($property_root_url.'/home'),'property_id'=>$property_id,'name'=>'home','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'1c6e846e-7229-4017-9232-ca4d306245ce','url'=>urlencode($property_root_url.'/hostedSolutionDallas'),'property_id'=>$property_id,'name'=>'hostedSolutionDallas','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'bc9157e7-269d-47b8-ad9f-8ac81854f36c','url'=>urlencode($property_root_url.'/hyper-v-consulting'),'property_id'=>$property_id,'name'=>'hyper-v-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'ae42179d-f76c-42b5-bb95-ef02379978d6','url'=>urlencode($property_root_url.'/hyperv-clustering-failing'),'property_id'=>$property_id,'name'=>'hyperv-clustering-failing','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'0a24c901-59f8-4e34-9c02-4b1f37261bbf','url'=>urlencode($property_root_url.'/iis-professional-assessment-iis-performance-tuning'),'property_id'=>$property_id,'name'=>'iis-professional-assessment-iis-performance-tuning','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'103e574c-ea5a-4dee-a28a-aef6c55215b0','url'=>urlencode($property_root_url.'/internet-datacenter-and-colo-support'),'property_id'=>$property_id,'name'=>'internet-datacenter-and-colo-support','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'cadca1a3-19dd-4f01-95e5-3d87bbeae707','url'=>urlencode($property_root_url.'/it-consulting-research-and-advisory'),'property_id'=>$property_id,'name'=>'it-consulting-research-and-advisory','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'dde60f99-5723-4a79-b81a-78e721b25ce3','url'=>urlencode($property_root_url.'/it-consulting-services'),'property_id'=>$property_id,'name'=>'it-consulting-services','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'557b71fe-7916-4e07-8046-268c969bfd63','url'=>urlencode($property_root_url.'/it-help-desk-desktop-support'),'property_id'=>$property_id,'name'=>'it-help-desk-desktop-support','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'1407f8b5-6fbc-4246-820a-24d0914255b4','url'=>urlencode($property_root_url.'/managedServices'),'property_id'=>$property_id,'name'=>'managedServices','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'17e18c15-5024-4529-a29a-e0ab82746778','url'=>urlencode($property_root_url.'/microsoft-exchange-2007-expert-consultants'),'property_id'=>$property_id,'name'=>'microsoft-exchange-2007-expert-consultants','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'41454501-c3d3-4e82-8f02-218db29daf9f','url'=>urlencode($property_root_url.'/microsoft-exchange-2010-deployment-experts'),'property_id'=>$property_id,'name'=>'microsoft-exchange-2010-deployment-experts','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'3b2b29b9-e4ca-4309-bd34-c831bd2bbc46','url'=>urlencode($property_root_url.'/microsoft-exchange-2016'),'property_id'=>$property_id,'name'=>'microsoft-exchange-2016','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'25f42ce2-0513-4f1e-8d3c-27bc9a25e2f2','url'=>urlencode($property_root_url.'/microsoft-exchange-server-2010-migration'),'property_id'=>$property_id,'name'=>'microsoft-exchange-server-2010-migration','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f626fc9d-88e4-42c8-b054-a7de0324a879','url'=>urlencode($property_root_url.'/microsoft-exchange-server-24x7-emergency-support'),'property_id'=>$property_id,'name'=>'microsoft-exchange-server-24x7-emergency-support','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'464e41e4-6bb1-4b7b-bb42-8b3afb08b6a6','url'=>urlencode($property_root_url.'/microsoft-exchange-server-email-protection-consultants'),'property_id'=>$property_id,'name'=>'microsoft-exchange-server-email-protection-consultants','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'041e2721-b743-4b6d-8e92-b94629749fb1','url'=>urlencode($property_root_url.'/microsoft-exchange-server-support-and-consulting'),'property_id'=>$property_id,'name'=>'microsoft-exchange-server-support-and-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'90662549-0c78-445e-b889-6b2b3f2f141b','url'=>urlencode($property_root_url.'/microsoft-gold-certified-partner-it-outsourcing-24x7x365-support'),'property_id'=>$property_id,'name'=>'microsoft-gold-certified-partner-it-outsourcing-24x7x365-support','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'45bcbf2d-6911-416f-8851-febcd09b69d6','url'=>urlencode($property_root_url.'/microsoft-network-load-balancing-expertise'),'property_id'=>$property_id,'name'=>'microsoft-network-load-balancing-expertise','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'5d278e40-5310-41c7-9b9a-fa767016b092','url'=>urlencode($property_root_url.'/microsoft-presentation-virtualization-consulting-experts'),'property_id'=>$property_id,'name'=>'microsoft-presentation-virtualization-consulting-experts','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'53c487fd-7c3e-49ff-9135-7bd6a1d8ac6b','url'=>urlencode($property_root_url.'/microsoft-system-center-configuration-manager'),'property_id'=>$property_id,'name'=>'microsoft-system-center-configuration-manager','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'83cfeb93-faea-4a9e-a89e-e0df464dcb1f','url'=>urlencode($property_root_url.'/microsoft-vdi-consulting'),'property_id'=>$property_id,'name'=>'microsoft-vdi-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'eafc13e6-4de6-4669-b464-47e81fb56c96','url'=>urlencode($property_root_url.'/microsoft-virtualization-consulting'),'property_id'=>$property_id,'name'=>'microsoft-virtualization-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'e22ac814-755f-416b-8145-4d1b1df56d57','url'=>urlencode($property_root_url.'/microsoft-windows-essential-business-server-2008-experts'),'property_id'=>$property_id,'name'=>'microsoft-windows-essential-business-server-2008-experts','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'2b176a0f-afee-4d49-9598-210451e16a9c','url'=>urlencode($property_root_url.'/microsoftExchange'),'property_id'=>$property_id,'name'=>'microsoftExchange','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'00d7e624-ec52-47ee-aa2a-6980c6d87a09','url'=>urlencode($property_root_url.'/network-and-server-solutions'),'property_id'=>$property_id,'name'=>'network-and-server-solutions','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'464bcff8-7c35-4ee0-b537-2b0b2b83e2be','url'=>urlencode($property_root_url.'/referralProgram'),'property_id'=>$property_id,'name'=>'referralProgram','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'5fcd0fa0-84f9-4223-aa3e-edb7597cf4a9','url'=>urlencode($property_root_url.'/security_assessment'),'property_id'=>$property_id,'name'=>'security_assessment','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'361e7961-b5b4-4423-a83d-c6b5579502ce','url'=>urlencode($property_root_url.'/servicesAndSolutions'),'property_id'=>$property_id,'name'=>'servicesAndSolutions','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'dfc80522-d011-494e-ac5f-86d7accac19f','url'=>urlencode($property_root_url.'/sqlServerPerfomanceTuning'),'property_id'=>$property_id,'name'=>'sqlServerPerfomanceTuning','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'5fdde682-1aca-4a0d-b6b1-614631044124','url'=>urlencode($property_root_url.'/support-center'),'property_id'=>$property_id,'name'=>'support-center','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'086cbeee-5e7e-4c06-a8d7-ec4bbcf8f761','url'=>urlencode($property_root_url.'/virtual-cio'),'property_id'=>$property_id,'name'=>'virtual-cio','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'90a58a51-7c22-407c-bb8b-d15d39172231','url'=>urlencode($property_root_url.'/virtual-server-consolidation-consulting'),'property_id'=>$property_id,'name'=>'virtual-server-consolidation-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'aae7a18b-1a06-4a9e-9b27-b063ef360a13','url'=>urlencode($property_root_url.'/virtualization'),'property_id'=>$property_id,'name'=>'virtualization','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f0da2499-a89b-47e3-8ea2-769826ccf3a0','url'=>urlencode($property_root_url.'/vmware-consultants-experts-on-server-virtualization'),'property_id'=>$property_id,'name'=>'vmware-consultants-experts-on-server-virtualization','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'dccb85d8-afdf-47a1-8164-c0e9a00c5b3e','url'=>urlencode($property_root_url.'/vmware-consultants-experts'),'property_id'=>$property_id,'name'=>'vmware-consultants-experts','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'7d48be3f-d896-4209-92b8-db26ad21ecc5','url'=>urlencode($property_root_url.'/vmware-consulting-virtualization-for-business'),'property_id'=>$property_id,'name'=>'vmware-consulting-virtualization-for-business','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'5ba84807-b917-46f4-908a-d8025cee2747','url'=>urlencode($property_root_url.'/vmware-esxi'),'property_id'=>$property_id,'name'=>'vmware-esxi','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'2ddfe115-741e-4291-b6f4-ea16fec259ca','url'=>urlencode($property_root_url.'/vmware-infrastructure'),'property_id'=>$property_id,'name'=>'vmware-infrastructure','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f0fbb198-26dd-4581-9657-2396352effd9','url'=>urlencode($property_root_url.'/vmware-vdi-an-integrated-desktop-virtualization-solution'),'property_id'=>$property_id,'name'=>'vmware-vdi-an-integrated-desktop-virtualization-solution','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'92c6d725-2e32-45f8-82d8-2f58ca27480f','url'=>urlencode($property_root_url.'/what-is-vmware-infrastructure-3'),'property_id'=>$property_id,'name'=>'what-is-vmware-infrastructure-3','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'56083273-af22-448e-8936-beae8acb9b35','url'=>urlencode($property_root_url.'/why-lg'),'property_id'=>$property_id,'name'=>'why-lg','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'00274ec5-cab4-458a-8b11-de39df1b90d1','url'=>urlencode($property_root_url.'/windows-consulting'),'property_id'=>$property_id,'name'=>'windows-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'43cc4021-0283-4da8-a3fc-8c3ddad02063','url'=>urlencode($property_root_url.'/windows-server-2008-consulting'),'property_id'=>$property_id,'name'=>'windows-server-2008-consulting','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'f32b327c-af4a-4995-8d2b-9424e64019ac','url'=>urlencode($property_root_url.'/windows-server-2012-help-professional-services-and-technical-assistance'),'property_id'=>$property_id,'name'=>'windows-server-2012-help-professional-services-and-technical-assistance','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'163567d0-a799-44a8-87d3-284439a4207b','url'=>urlencode($property_root_url.'/windows-server-2016'),'property_id'=>$property_id,'name'=>'windows-server-2016','created_at'=>$now,'updated_at'=>$now],
            ['id'=>'54c60df9-0d0a-4ce4-9119-3e4b888d5ffd','url'=>urlencode($property_root_url.'/windows-server-editions-for-virtualization'),'property_id'=>$property_id,'name'=>'windows-server-editions-for-virtualization','created_at'=>$now,'updated_at'=>$now]

        ];
        return $pages;
    }

}