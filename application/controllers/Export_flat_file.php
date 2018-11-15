<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Export_flat_file extends CI_Controller {


	public function __construct(){
		parent::__construct();
        $this->load->model('Common_Model');
   }

   public function index()
   {
     $query = "select
     preg_woman.`PWID` as pw_PWID,
     preg_woman.`PWGUID` as pw_PWGUID,
     preg_woman.`HHGUID` as pw_HHGUID,
     preg_woman.`HHFamilyMemberGUID` as pw_HHFamilyMemberGUID,
     preg_woman.`PWName` as pw_PWName,
     preg_woman.`ANMID` as pw_ANMID,
     preg_woman.`AshaID` as pw_AshaID,
     preg_woman.`LMPDate` as pw_LMPDate,
     preg_woman.`EDDDate` as pw_EDDDate,
     preg_woman.`PWRegistrationDate` as pw_PWRegistrationDate,
     preg_woman.`Regwithin12weeks` as pw_Regwithin12weeks,
     preg_woman.`RegweeksElaspsed` as pw_RegweeksElaspsed,
     preg_woman.`HusbandName` as pw_HusbandName,
     preg_woman.`Husband_GUID` as pw_Husband_GUID,
     preg_woman.`MobileNo` as pw_MobileNo,
     preg_woman.`MotherMCTSID` as pw_MotherMCTSID,
     preg_woman.`IFSCCode` as pw_IFSCCode,
     preg_woman.`Accountno` as pw_Accountno,
     preg_woman.`JSYBenificiaryYN` as pw_JSYBenificiaryYN,
     preg_woman.`JSYRegDate` as pw_JSYRegDate,
     preg_woman.`JSYPaymentReceivedYN` as pw_JSYPaymentReceivedYN,
     preg_woman.`PWDOB` as pw_PWDOB,
     preg_woman.`PWAgeYears` as pw_PWAgeYears,
     preg_woman.`PWAgeRefDate` as pw_PWAgeRefDate,
     preg_woman.`PWWeight` as pw_PWWeight,
     preg_woman.`PWBloodGroup` as pw_PWBloodGroup,
     preg_woman.`PastIllnessYN` as pw_PastIllnessYN,
     preg_woman.`TotalPregnancy` as pw_TotalPregnancy,
     preg_woman.`LastPregnancyResult` as pw_LastPregnancyResult,
     preg_woman.`LastPregnancyComplication` as pw_LastPregnancyComplication,
     preg_woman.`LTLPregnancyResult` as pw_LTLPregnancyResult,
     preg_woman.`LTLPregnancyomplication` as pw_LTLPregnancyomplication,
     preg_woman.`ExpFacilityforDelivery` as pw_ExpFacilityforDelivery,
     preg_woman.`ExpFacilityforDeliveryName` as pw_ExpFacilityforDeliveryName,
     preg_woman.`VDRLTestYN` as pw_VDRLTestYN,
     preg_woman.`VDRLResult` as pw_VDRLResult,
     preg_woman.`HIVTestYN` as pw_HIVTestYN,
     preg_woman.`HIVResult` as pw_HIVResult,
     preg_woman.`Visit1Date` as pw_Visit1Date,
     preg_woman.`Visit2Date` as pw_Visit2Date,
     preg_woman.`Visit3Date` as pw_Visit3Date,
     preg_woman.`Visit4Date` as pw_Visit4Date,
     preg_woman.`ISAbortion` as pw_ISAbortion,
     preg_woman.`AbortionFacilityType` as pw_AbortionFacilityType,
     preg_woman.`NoofANCVisitsDone` as pw_NoofANCVisitsDone,
     preg_woman.`LastANCVisitDate` as pw_LastANCVisitDate,
     preg_woman.`TT1Date` as pw_TT1Date,
     preg_woman.`TT2Date` as pw_TT2Date,
     preg_woman.`TTBoosterDate` as pw_TTBoosterDate,
     preg_woman.`DangerSigns` as pw_DangerSigns,
     preg_woman.`RefferedYN` as pw_RefferedYN,
     preg_woman.`DeliveryDateTime` as pw_DeliveryDateTime,
     preg_woman.`DeliveryPlace` as pw_DeliveryPlace,
     preg_woman.`DeliveryConductedBy` as pw_DeliveryConductedBy,
     preg_woman.`DeliveryType` as pw_DeliveryType,
     preg_woman.`DeliveryComplication` as pw_DeliveryComplication,
     preg_woman.`MotherDeathCause` as pw_MotherDeathCause,
     preg_woman.`DeliveryOutcome` as pw_DeliveryOutcome,
     preg_woman.`DTMFacilityDischarge` as pw_DTMFacilityDischarge,
     preg_woman.`PaymentRecieved` as pw_PaymentRecieved,
     preg_woman.`CreatedOn` as pw_CreatedOn,
     preg_woman.`CreatedBy` as pw_CreatedBy,
     preg_woman.`UpdatedOn` as pw_UpdatedOn,
     preg_woman.`UpdatedBy` as pw_UpdatedBy,
     preg_woman.`IsEdited` as pw_IsEdited,
     preg_woman.`IsUploaded` as pw_IsUploaded,
     preg_woman.`PWHeight` as pw_PWHeight,
     preg_woman.`LastPregDeliveryPlace` as pw_LastPregDeliveryPlace,
     preg_woman.`LasttolastPregDeliveryPlace` as pw_LasttolastPregDeliveryPlace,
     preg_woman.`PWImage` as pw_PWImage,
     preg_woman.`PlaceofDeath` as pw_PlaceofDeath,
     preg_woman.`DateofDeath` as pw_DateofDeath,
     preg_woman.`OtherPlaceofDeath` as pw_OtherPlaceofDeath,
     preg_woman.`AnyOtherPastIllness` as pw_AnyOtherPastIllness,
     preg_woman.`AnyOtherLastPregCom` as pw_AnyOtherLastPregCom,
     preg_woman.`AnyOtherLTLPregCom` as pw_AnyOtherLTLPregCom,
     preg_woman.`HighRisk` as pw_HighRisk,
     preg_woman.`MaternalDeath` as pw_MaternalDeath,
     preg_woman.`IsPregnant` as pw_IsPregnant,
     preg_woman.`BankAcc` as pw_BankAcc,
     preg_woman.`ChildDeathCause` as pw_ChildDeathCause,
     preg_woman.`MotherDCOther` as pw_MotherDCOther,
     preg_woman.`DeathPlaceOther` as pw_DeathPlaceOther,
     preg_woman.`FacitylastPreg` as pw_FacitylastPreg,
     preg_woman.`FaciltyOtherLTL` as pw_FaciltyOtherLTL,
     preg_woman.`FacityLTL` as pw_FacityLTL,
     preg_woman.`FacilityOtherLastpreg` as pw_FacilityOtherLastpreg,
     preg_woman.`Education` as pw_Education,
     preg_woman.`AltMobileNo` as pw_AltMobileNo,
     preg_woman.`Abortion_FacilityName` as pw_Abortion_FacilityName,
     preg_woman.`IsDeleted` as pw_IsDeleted,
     hh.`HHUID` as hh_HHUID,
     hh.`HHSurveyGUID` as hh_HHSurveyGUID,
     hh.`SubCenterID` as hh_SubCenterID,
     hh.`ANMID` as hh_ANMID,
     hh.`VillageID` as hh_VillageID,
     hh.`ServiceProviderID` as hh_ServiceProviderID,
     hh.`HHCode` as hh_HHCode,
     hh.`FamilyCode` as hh_FamilyCode,
     hh.`HHStatusID` as hh_HHStatusID,
     hh.`CasteID` as hh_CasteID,
     hh.`FinancialStatusID` as hh_FinancialStatusID,
     hh.`CreatedBy` as hh_CreatedBy,
     hh.`CreatedOn` as hh_CreatedOn,
     hh.`UploadedBy` as hh_UploadedBy,
     hh.`UploadedOn` as hh_UploadedOn,
     hh.`IsTablet` as hh_IsTablet,
     hh.`IsDeleted` as hh_IsDeleted,
     hh.`Verified` as hh_Verified,
     hh.`ChAreaID` as hh_ChAreaID,
     hh.`CHS_ID` as hh_CHS_ID,
     hh.`HHShortName` as hh_HHShortName,
     hh.`ReligionID` as hh_ReligionID,
     hh.`Latitude` as hh_Latitude,
     hh.`Longitude` as hh_Longitude,
     hh.`Location` as hh_Location,
     hh.`MigrateInDate` as hh_MigrateInDate,
     hh.`MigrateOutDate` as hh_MigrateOutDate,
     hh.`createdon1` as hh_createdon1,
     hh.`Anypremature_Death` as hh_Anypremature_Death,
     hh.`Anypremature_DeathYes` as hh_Anypremature_DeathYes,
     hh.`Toilet` as hh_Toilet,
     hh.`Waste_Disposal` as hh_Waste_Disposal,
     hh.`Drinking_Water` as hh_Drinking_Water,
     hh.`Electricity` as hh_Electricity,
     hh.`Cooking_Fuel` as hh_Cooking_Fuel,
     hh.`House_Type` as hh_House_Type,
     hh.`Hamlet` as hh_Hamlet,
     fm.`HHUID` as fm_HHUID,
     fm.`HHFamilyMemberUID` as fm_HHFamilyMemberUID,
     fm.`HHFamilyMemberGUID` as fm_HHFamilyMemberGUID,
     fm.`HHSurveyGUID` as fm_HHSurveyGUID,
     fm.`HHFamilyMemberCode` as fm_HHFamilyMemberCode,
     fm.`UniqueIDNumber` as fm_UniqueIDNumber,
     fm.`FamilyMemberName` as fm_FamilyMemberName,
     fm.`RelationID` as fm_RelationID,
     fm.`GenderID` as fm_GenderID,
     fm.`StatusID` as fm_StatusID,
     fm.`MaritialStatusID` as fm_MaritialStatusID,
     fm.`DOBAvailable` as fm_DOBAvailable,
     fm.`DateOfBirth` as fm_DateOfBirth,
     fm.`AgeAsOnYear` as fm_AgeAsOnYear,
     fm.`AprilAgeYear` as fm_AprilAgeYear,
     fm.`AprilAgeMonth` as fm_AprilAgeMonth,
     fm.`MotherGUID` as fm_MotherGUID,
     fm.`TargetID` as fm_TargetID,
     fm.`CreatedBy` as fm_CreatedBy,
     fm.`CreatedOn` as fm_CreatedOn,
     fm.`UploadedBy` as fm_UploadedBy,
     fm.`UploadedOn` as fm_UploadedOn,
     fm.`IsTablet` as fm_IsTablet,
     fm.`IsDeleted` as fm_IsDeleted,
     fm.`Father` as fm_Father,
     fm.`Mother` as fm_Mother,
     fm.`Spouse` as fm_Spouse,
     fm.`TempMember` as fm_TempMember,
     fm.`AshaID` as fm_AshaID,
     fm.`ANMID` as fm_ANMID,
     fm.`Education` as fm_Education,
     fm.`DateOfDeath` as fm_DateOfDeath,
     fm.`PlaceOfDeath` as fm_PlaceOfDeath,
     fm.`NameofDeathplace` as fm_NameofDeathplace,
     fm.`DeathVillage` as fm_DeathVillage,
     fm.`Registration_Date` as fm_Registration_Date,
     fm.`Occupation` as fm_Occupation,
     fm.`Rsby_Beneficiary` as fm_Rsby_Beneficiary,
     fm.`Health_Condition` as fm_Health_Condition,
     fm.`Any_HealthIssue` as fm_Any_HealthIssue,
     fm.`Any_PhysicalInability` as fm_Any_PhysicalInability,
     fm.`Occupation_Other` as fm_Occupation_Other,
     fm.`Phone_No` as fm_Phone_No,
     fm.`Any_HealthIssue_Other` as fm_Any_HealthIssue_Other,
     fm.`Other_Id_Type` as fm_Other_Id_Type,
     fm.`Other_Id` as fm_Other_Id,
     fm.`Other_Id_Name` as fm_Other_Id_Name,
     anc_visit_1.`AncVisitID` as anc1_AncVisitID,
     anc_visit_1.`PWGUID` as anc1_PWGUID,
     anc_visit_1.`VisitGUID` as anc1_VisitGUID,
     anc_visit_1.`ByANMID` as anc1_ByANMID,
     anc_visit_1.`ByAshaID` as anc1_ByAshaID,
     anc_visit_1.`MCTSID` as anc1_MCTSID,
     anc_visit_1.`Visit_No` as anc1_Visit_No,
     anc_visit_1.`Trimester` as anc1_Trimester,
     anc_visit_1.`VisitDueDate` as anc1_VisitDueDate,
     anc_visit_1.`CheckupVisitDate` as anc1_CheckupVisitDate,
     anc_visit_1.`CheckupPlace` as anc1_CheckupPlace,
     anc_visit_1.`BirthWeight` as anc1_BirthWeight,
     anc_visit_1.`BP` as anc1_BP,
     anc_visit_1.`Hemoglobin` as anc1_Hemoglobin,
     anc_visit_1.`UrineTest` as anc1_UrineTest,
     anc_visit_1.`TTfirstDoseDate` as anc1_TTfirstDoseDate,
     anc_visit_1.`TTsecondDoseDate` as anc1_TTsecondDoseDate,
     anc_visit_1.`TTboosterDate` as anc1_TTboosterDate,
     anc_visit_1.`VDRLTest` as anc1_VDRLTest,
     anc_visit_1.`HIVTest` as anc1_HIVTest,
     anc_visit_1.`BPResult` as anc1_BPResult,
     anc_visit_1.`UrineSugar` as anc1_UrineSugar,
     anc_visit_1.`UrineAlbumin` as anc1_UrineAlbumin,
     anc_visit_1.`UltraSound` as anc1_UltraSound,
     anc_visit_1.`UltraSoundConductedby` as anc1_UltraSoundConductedby,
     anc_visit_1.`IFARecieved` as anc1_IFARecieved,
     anc_visit_1.`NumberIFARecieved` as anc1_NumberIFARecieved,
     anc_visit_1.`UltrasoundResult` as anc1_UltrasoundResult,
     anc_visit_1.`HomeVisitDate` as anc1_HomeVisitDate,
     anc_visit_1.`PregWomenReg` as anc1_PregWomenReg,
     anc_visit_1.`McpCard` as anc1_McpCard,
     anc_visit_1.`TT1` as anc1_TT1,
     anc_visit_1.`TT1date` as anc1_TT1date,
     anc_visit_1.`TT2` as anc1_TT2,
     anc_visit_1.`TT2date` as anc1_TT2date,
     anc_visit_1.`TTbooster` as anc1_TTbooster,
     anc_visit_1.`TTboosterDate1` as anc1_TTboosterDate1,
     anc_visit_1.`Weight1` as anc1_Weight1,
     anc_visit_1.`BP1` as anc1_BP1,
     anc_visit_1.`HB1` as anc1_HB1,
     anc_visit_1.`UrineTestsugar1` as anc1_UrineTestsugar1,
     anc_visit_1.`UrineTestAl1` as anc1_UrineTestAl1,
     anc_visit_1.`IronTablet1` as anc1_IronTablet1,
     anc_visit_1.`AncCheckup1` as anc1_AncCheckup1,
     anc_visit_1.`Weight1YN` as anc1_Weight1YN,
     anc_visit_1.`BP1YN` as anc1_BP1YN,
     anc_visit_1.`HB1YN` as anc1_HB1YN,
     anc_visit_1.`UrineTestsugar1YN` as anc1_UrineTestsugar1YN,
     anc_visit_1.`UrineTestAl1YN` as anc1_UrineTestAl1YN,
     anc_visit_1.`IronTablet1YN` as anc1_IronTablet1YN,
     anc_visit_1.`AncCheckup1YN` as anc1_AncCheckup1YN,
     anc_visit_1.`DeliveryONhospYN` as anc1_DeliveryONhospYN,
     anc_visit_1.`FamilyPlanning` as anc1_FamilyPlanning,
     anc_visit_1.`DangerSign` as anc1_DangerSign,
     anc_visit_1.`CalciumReceived` as anc1_CalciumReceived,
     anc_visit_1.`CalciumTablet` as anc1_CalciumTablet,
     anc_visit_1.`TT1TT2last2yr` as anc1_TT1TT2last2yr,
     anc_visit_2.`AncVisitID` as anc2_AncVisitID,
     anc_visit_2.`PWGUID` as anc2_PWGUID,
     anc_visit_2.`VisitGUID` as anc2_VisitGUID,
     anc_visit_2.`ByANMID` as anc2_ByANMID,
     anc_visit_2.`ByAshaID` as anc2_ByAshaID,
     anc_visit_2.`MCTSID` as anc2_MCTSID,
     anc_visit_2.`Visit_No` as anc2_Visit_No,
     anc_visit_2.`Trimester` as anc2_Trimester,
     anc_visit_2.`VisitDueDate` as anc2_VisitDueDate,
     anc_visit_2.`CheckupVisitDate` as anc2_CheckupVisitDate,
     anc_visit_2.`CheckupPlace` as anc2_CheckupPlace,
     anc_visit_2.`BirthWeight` as anc2_BirthWeight,
     anc_visit_2.`BP` as anc2_BP,
     anc_visit_2.`Hemoglobin` as anc2_Hemoglobin,
     anc_visit_2.`UrineTest` as anc2_UrineTest,
     anc_visit_2.`TTfirstDoseDate` as anc2_TTfirstDoseDate,
     anc_visit_2.`TTsecondDoseDate` as anc2_TTsecondDoseDate,
     anc_visit_2.`TTboosterDate` as anc2_TTboosterDate,
     anc_visit_2.`VDRLTest` as anc2_VDRLTest,
     anc_visit_2.`HIVTest` as anc2_HIVTest,
     anc_visit_2.`BPResult` as anc2_BPResult,
     anc_visit_2.`UrineSugar` as anc2_UrineSugar,
     anc_visit_2.`UrineAlbumin` as anc2_UrineAlbumin,
     anc_visit_2.`UltraSound` as anc2_UltraSound,
     anc_visit_2.`UltraSoundConductedby` as anc2_UltraSoundConductedby,
     anc_visit_2.`IFARecieved` as anc2_IFARecieved,
     anc_visit_2.`NumberIFARecieved` as anc2_NumberIFARecieved,
     anc_visit_2.`UltrasoundResult` as anc2_UltrasoundResult,
     anc_visit_2.`HomeVisitDate` as anc2_HomeVisitDate,
     anc_visit_2.`PregWomenReg` as anc2_PregWomenReg,
     anc_visit_2.`McpCard` as anc2_McpCard,
     anc_visit_2.`TT1` as anc2_TT1,
     anc_visit_2.`TT1date` as anc2_TT1date,
     anc_visit_2.`TT2` as anc2_TT2,
     anc_visit_2.`TT2date` as anc2_TT2date,
     anc_visit_2.`TTbooster` as anc2_TTbooster,
     anc_visit_2.`TTboosterDate1` as anc2_TTboosterDate1,
     anc_visit_2.`Weight1` as anc2_Weight1,
     anc_visit_2.`BP1` as anc2_BP1,
     anc_visit_2.`HB1` as anc2_HB1,
     anc_visit_2.`UrineTestsugar1` as anc2_UrineTestsugar1,
     anc_visit_2.`UrineTestAl1` as anc2_UrineTestAl1,
     anc_visit_2.`IronTablet1` as anc2_IronTablet1,
     anc_visit_2.`AncCheckup1` as anc2_AncCheckup1,
     anc_visit_2.`Weight1YN` as anc2_Weight1YN,
     anc_visit_2.`BP1YN` as anc2_BP1YN,
     anc_visit_2.`HB1YN` as anc2_HB1YN,
     anc_visit_2.`UrineTestsugar1YN` as anc2_UrineTestsugar1YN,
     anc_visit_2.`UrineTestAl1YN` as anc2_UrineTestAl1YN,
     anc_visit_2.`IronTablet1YN` as anc2_IronTablet1YN,
     anc_visit_2.`AncCheckup1YN` as anc2_AncCheckup1YN,
     anc_visit_2.`DeliveryONhospYN` as anc2_DeliveryONhospYN,
     anc_visit_2.`FamilyPlanning` as anc2_FamilyPlanning,
     anc_visit_2.`DangerSign` as anc2_DangerSign,
     anc_visit_2.`CalciumReceived` as anc2_CalciumReceived,
     anc_visit_2.`CalciumTablet` as anc2_CalciumTablet,
     anc_visit_2.`TT1TT2last2yr` as anc2_TT1TT2last2yr,
     anc_visit_3.`AncVisitID` as anc3_AncVisitID,
     anc_visit_3.`PWGUID` as anc3_PWGUID,
     anc_visit_3.`VisitGUID` as anc3_VisitGUID,
     anc_visit_3.`ByANMID` as anc3_ByANMID,
     anc_visit_3.`ByAshaID` as anc3_ByAshaID,
     anc_visit_3.`MCTSID` as anc3_MCTSID,
     anc_visit_3.`Visit_No` as anc3_Visit_No,
     anc_visit_3.`Trimester` as anc3_Trimester,
     anc_visit_3.`VisitDueDate` as anc3_VisitDueDate,
     anc_visit_3.`CheckupVisitDate` as anc3_CheckupVisitDate,
     anc_visit_3.`CheckupPlace` as anc3_CheckupPlace,
     anc_visit_3.`BirthWeight` as anc3_BirthWeight,
     anc_visit_3.`BP` as anc3_BP,
     anc_visit_3.`Hemoglobin` as anc3_Hemoglobin,
     anc_visit_3.`UrineTest` as anc3_UrineTest,
     anc_visit_3.`TTfirstDoseDate` as anc3_TTfirstDoseDate,
     anc_visit_3.`TTsecondDoseDate` as anc3_TTsecondDoseDate,
     anc_visit_3.`TTboosterDate` as anc3_TTboosterDate,
     anc_visit_3.`VDRLTest` as anc3_VDRLTest,
     anc_visit_3.`HIVTest` as anc3_HIVTest,
     anc_visit_3.`BPResult` as anc3_BPResult,
     anc_visit_3.`UrineSugar` as anc3_UrineSugar,
     anc_visit_3.`UrineAlbumin` as anc3_UrineAlbumin,
     anc_visit_3.`UltraSound` as anc3_UltraSound,
     anc_visit_3.`UltraSoundConductedby` as anc3_UltraSoundConductedby,
     anc_visit_3.`IFARecieved` as anc3_IFARecieved,
     anc_visit_3.`NumberIFARecieved` as anc3_NumberIFARecieved,
     anc_visit_3.`UltrasoundResult` as anc3_UltrasoundResult,
     anc_visit_3.`HomeVisitDate` as anc3_HomeVisitDate,
     anc_visit_3.`PregWomenReg` as anc3_PregWomenReg,
     anc_visit_3.`McpCard` as anc3_McpCard,
     anc_visit_3.`TT1` as anc3_TT1,
     anc_visit_3.`TT1date` as anc3_TT1date,
     anc_visit_3.`TT2` as anc3_TT2,
     anc_visit_3.`TT2date` as anc3_TT2date,
     anc_visit_3.`TTbooster` as anc3_TTbooster,
     anc_visit_3.`TTboosterDate1` as anc3_TTboosterDate1,
     anc_visit_3.`Weight1` as anc3_Weight1,
     anc_visit_3.`BP1` as anc3_BP1,
     anc_visit_3.`HB1` as anc3_HB1,
     anc_visit_3.`UrineTestsugar1` as anc3_UrineTestsugar1,
     anc_visit_3.`UrineTestAl1` as anc3_UrineTestAl1,
     anc_visit_3.`IronTablet1` as anc3_IronTablet1,
     anc_visit_3.`AncCheckup1` as anc3_AncCheckup1,
     anc_visit_3.`Weight1YN` as anc3_Weight1YN,
     anc_visit_3.`BP1YN` as anc3_BP1YN,
     anc_visit_3.`HB1YN` as anc3_HB1YN,
     anc_visit_3.`UrineTestsugar1YN` as anc3_UrineTestsugar1YN,
     anc_visit_3.`UrineTestAl1YN` as anc3_UrineTestAl1YN,
     anc_visit_3.`IronTablet1YN` as anc3_IronTablet1YN,
     anc_visit_3.`AncCheckup1YN` as anc3_AncCheckup1YN,
     anc_visit_3.`DeliveryONhospYN` as anc3_DeliveryONhospYN,
     anc_visit_3.`FamilyPlanning` as anc3_FamilyPlanning,
     anc_visit_3.`DangerSign` as anc3_DangerSign,
     anc_visit_3.`CalciumReceived` as anc3_CalciumReceived,
     anc_visit_3.`CalciumTablet` as anc3_CalciumTablet,
     anc_visit_3.`TT1TT2last2yr` as anc3_TT1TT2last2yr,
     anc_visit_4.`AncVisitID` as anc4_AncVisitID,
     anc_visit_4.`PWGUID` as anc4_PWGUID,
     anc_visit_4.`VisitGUID` as anc4_VisitGUID,
     anc_visit_4.`ByANMID` as anc4_ByANMID,
     anc_visit_4.`ByAshaID` as anc4_ByAshaID,
     anc_visit_4.`MCTSID` as anc4_MCTSID,
     anc_visit_4.`Visit_No` as anc4_Visit_No,
     anc_visit_4.`Trimester` as anc4_Trimester,
     anc_visit_4.`VisitDueDate` as anc4_VisitDueDate,
     anc_visit_4.`CheckupVisitDate` as anc4_CheckupVisitDate,
     anc_visit_4.`CheckupPlace` as anc4_CheckupPlace,
     anc_visit_4.`BirthWeight` as anc4_BirthWeight,
     anc_visit_4.`BP` as anc4_BP,
     anc_visit_4.`Hemoglobin` as anc4_Hemoglobin,
     anc_visit_4.`UrineTest` as anc4_UrineTest,
     anc_visit_4.`TTfirstDoseDate` as anc4_TTfirstDoseDate,
     anc_visit_4.`TTsecondDoseDate` as anc4_TTsecondDoseDate,
     anc_visit_4.`TTboosterDate` as anc4_TTboosterDate,
     anc_visit_4.`VDRLTest` as anc4_VDRLTest,
     anc_visit_4.`HIVTest` as anc4_HIVTest,
     anc_visit_4.`BPResult` as anc4_BPResult,
     anc_visit_4.`UrineSugar` as anc4_UrineSugar,
     anc_visit_4.`UrineAlbumin` as anc4_UrineAlbumin,
     anc_visit_4.`UltraSound` as anc4_UltraSound,
     anc_visit_4.`UltraSoundConductedby` as anc4_UltraSoundConductedby,
     anc_visit_4.`IFARecieved` as anc4_IFARecieved,
     anc_visit_4.`NumberIFARecieved` as anc4_NumberIFARecieved,
     anc_visit_4.`UltrasoundResult` as anc4_UltrasoundResult,
     anc_visit_4.`HomeVisitDate` as anc4_HomeVisitDate,
     anc_visit_4.`PregWomenReg` as anc4_PregWomenReg,
     anc_visit_4.`McpCard` as anc4_McpCard,
     anc_visit_4.`TT1` as anc4_TT1,
     anc_visit_4.`TT1date` as anc4_TT1date,
     anc_visit_4.`TT2` as anc4_TT2,
     anc_visit_4.`TT2date` as anc4_TT2date,
     anc_visit_4.`TTbooster` as anc4_TTbooster,
     anc_visit_4.`TTboosterDate1` as anc4_TTboosterDate1,
     anc_visit_4.`Weight1` as anc4_Weight1,
     anc_visit_4.`BP1` as anc4_BP1,
     anc_visit_4.`HB1` as anc4_HB1,
     anc_visit_4.`UrineTestsugar1` as anc4_UrineTestsugar1,
     anc_visit_4.`UrineTestAl1` as anc4_UrineTestAl1,
     anc_visit_4.`IronTablet1` as anc4_IronTablet1,
     anc_visit_4.`AncCheckup1` as anc4_AncCheckup1,
     anc_visit_4.`Weight1YN` as anc4_Weight1YN,
     anc_visit_4.`BP1YN` as anc4_BP1YN,
     anc_visit_4.`HB1YN` as anc4_HB1YN,
     anc_visit_4.`UrineTestsugar1YN` as anc4_UrineTestsugar1YN,
     anc_visit_4.`UrineTestAl1YN` as anc4_UrineTestAl1YN,
     anc_visit_4.`IronTablet1YN` as anc4_IronTablet1YN,
     anc_visit_4.`AncCheckup1YN` as anc4_AncCheckup1YN,
     anc_visit_4.`DeliveryONhospYN` as anc4_DeliveryONhospYN,
     anc_visit_4.`FamilyPlanning` as anc4_FamilyPlanning,
     anc_visit_4.`DangerSign` as anc4_DangerSign,
     anc_visit_4.`CalciumReceived` as anc4_CalciumReceived,
     anc_visit_4.`CalciumTablet` as anc4_CalciumTablet,
     anc_visit_4.`TT1TT2last2yr` as anc4_TT1TT2last2yr,
     pnc_visit_1.`UID` as pnc1_UID,
     pnc_visit_1.`PWGUID` as pnc1_PWGUID,
     pnc_visit_1.`ChildGUID` as pnc1_ChildGUID,
     pnc_visit_1.`PNCGUID` as pnc1_PNCGUID,
     pnc_visit_1.`VisitNo` as pnc1_VisitNo,
     pnc_visit_1.`Q_0` as pnc1_Q_0,
     pnc_visit_1.`Q_1` as pnc1_Q_1,
     pnc_visit_1.`Q_2` as pnc1_Q_2,
     pnc_visit_1.`Q_3` as pnc1_Q_3,
     pnc_visit_1.`Q_4` as pnc1_Q_4,
     pnc_visit_1.`Q_5` as pnc1_Q_5,
     pnc_visit_1.`Q_6` as pnc1_Q_6,
     pnc_visit_1.`Q_7` as pnc1_Q_7,
     pnc_visit_1.`Q_8` as pnc1_Q_8,
     pnc_visit_1.`Q_9` as pnc1_Q_9,
     pnc_visit_1.`Q_10` as pnc1_Q_10,
     pnc_visit_1.`Q_12` as pnc1_Q_12,
     pnc_visit_1.`Q_13` as pnc1_Q_13,
     pnc_visit_1.`Q_14` as pnc1_Q_14,
     pnc_visit_1.`Q_15` as pnc1_Q_15,
     pnc_visit_1.`Q_16` as pnc1_Q_16,
     pnc_visit_1.`Q_17` as pnc1_Q_17,
     pnc_visit_1.`Q_18` as pnc1_Q_18,
     pnc_visit_1.`Q_19` as pnc1_Q_19,
     pnc_visit_1.`Q_20` as pnc1_Q_20,
     pnc_visit_1.`Q_21` as pnc1_Q_21,
     pnc_visit_1.`Q_22` as pnc1_Q_22,
     pnc_visit_1.`Q_23` as pnc1_Q_23,
     pnc_visit_1.`Q_24` as pnc1_Q_24,
     pnc_visit_1.`Q_25` as pnc1_Q_25,
     pnc_visit_1.`Q_26` as pnc1_Q_26,
     pnc_visit_1.`Q_27` as pnc1_Q_27,
     pnc_visit_1.`Q_28` as pnc1_Q_28,
     pnc_visit_1.`Q_29` as pnc1_Q_29,
     pnc_visit_1.`Q_30` as pnc1_Q_30,
     pnc_visit_1.`Q_32` as pnc1_Q_32,
     pnc_visit_1.`Q_33` as pnc1_Q_33,
     pnc_visit_1.`Q_34` as pnc1_Q_34,
     pnc_visit_1.`Q_35` as pnc1_Q_35,
     pnc_visit_1.`Q_36` as pnc1_Q_36,
     pnc_visit_1.`Q_37` as pnc1_Q_37,
     pnc_visit_1.`Q_38` as pnc1_Q_38,
     pnc_visit_1.`Q_39` as pnc1_Q_39,
     pnc_visit_1.`Q_40` as pnc1_Q_40,
     pnc_visit_1.`Q_41` as pnc1_Q_41,
     pnc_visit_1.`Q_43` as pnc1_Q_43,
     pnc_visit_1.`Q_44` as pnc1_Q_44,
     pnc_visit_1.`Q_45` as pnc1_Q_45,
     pnc_visit_1.`Q_46` as pnc1_Q_46,
     pnc_visit_1.`Q_47` as pnc1_Q_47,
     pnc_visit_1.`Q_48` as pnc1_Q_48,
     pnc_visit_1.`Q_49` as pnc1_Q_49,
     pnc_visit_1.`Q_50` as pnc1_Q_50,
     pnc_visit_1.`Q_52` as pnc1_Q_52,
     pnc_visit_1.`Q_53` as pnc1_Q_53,
     pnc_visit_1.`Q_54` as pnc1_Q_54,
     pnc_visit_1.`Q_55` as pnc1_Q_55,
     pnc_visit_1.`Q_56` as pnc1_Q_56,
     pnc_visit_1.`Q_57` as pnc1_Q_57,
     pnc_visit_1.`Q_58` as pnc1_Q_58,
     pnc_visit_1.`Q_59` as pnc1_Q_59,
     pnc_visit_1.`Q_60` as pnc1_Q_60,
     pnc_visit_1.`CreatedBy` as pnc1_CreatedBy,
     pnc_visit_1.`CreatedOn` as pnc1_CreatedOn,
     pnc_visit_1.`UpdatedBy` as pnc1_UpdatedBy,
     pnc_visit_1.`UpdatedOn` as pnc1_UpdatedOn,
     pnc_visit_1.`IsDeleted` as pnc1_IsDeleted,
     pnc_visit_1.`IsEdited` as pnc1_IsEdited,
     pnc_visit_1.`Q_38A` as pnc1_Q_38A,
     pnc_visit_1.`AshaID` as pnc1_AshaID,
     pnc_visit_1.`ANMID` as pnc1_ANMID,
     pnc_visit_2.`UID` as pnc2_UID,
     pnc_visit_2.`PWGUID` as pnc2_PWGUID,
     pnc_visit_2.`ChildGUID` as pnc2_ChildGUID,
     pnc_visit_2.`PNCGUID` as pnc2_PNCGUID,
     pnc_visit_2.`VisitNo` as pnc2_VisitNo,
     pnc_visit_2.`Q_0` as pnc2_Q_0,
     pnc_visit_2.`Q_1` as pnc2_Q_1,
     pnc_visit_2.`Q_2` as pnc2_Q_2,
     pnc_visit_2.`Q_3` as pnc2_Q_3,
     pnc_visit_2.`Q_4` as pnc2_Q_4,
     pnc_visit_2.`Q_5` as pnc2_Q_5,
     pnc_visit_2.`Q_6` as pnc2_Q_6,
     pnc_visit_2.`Q_7` as pnc2_Q_7,
     pnc_visit_2.`Q_8` as pnc2_Q_8,
     pnc_visit_2.`Q_9` as pnc2_Q_9,
     pnc_visit_2.`Q_10` as pnc2_Q_10,
     pnc_visit_2.`Q_12` as pnc2_Q_12,
     pnc_visit_2.`Q_13` as pnc2_Q_13,
     pnc_visit_2.`Q_14` as pnc2_Q_14,
     pnc_visit_2.`Q_15` as pnc2_Q_15,
     pnc_visit_2.`Q_16` as pnc2_Q_16,
     pnc_visit_2.`Q_17` as pnc2_Q_17,
     pnc_visit_2.`Q_18` as pnc2_Q_18,
     pnc_visit_2.`Q_19` as pnc2_Q_19,
     pnc_visit_2.`Q_20` as pnc2_Q_20,
     pnc_visit_2.`Q_21` as pnc2_Q_21,
     pnc_visit_2.`Q_22` as pnc2_Q_22,
     pnc_visit_2.`Q_23` as pnc2_Q_23,
     pnc_visit_2.`Q_24` as pnc2_Q_24,
     pnc_visit_2.`Q_25` as pnc2_Q_25,
     pnc_visit_2.`Q_26` as pnc2_Q_26,
     pnc_visit_2.`Q_27` as pnc2_Q_27,
     pnc_visit_2.`Q_28` as pnc2_Q_28,
     pnc_visit_2.`Q_29` as pnc2_Q_29,
     pnc_visit_2.`Q_30` as pnc2_Q_30,
     pnc_visit_2.`Q_32` as pnc2_Q_32,
     pnc_visit_2.`Q_33` as pnc2_Q_33,
     pnc_visit_2.`Q_34` as pnc2_Q_34,
     pnc_visit_2.`Q_35` as pnc2_Q_35,
     pnc_visit_2.`Q_36` as pnc2_Q_36,
     pnc_visit_2.`Q_37` as pnc2_Q_37,
     pnc_visit_2.`Q_38` as pnc2_Q_38,
     pnc_visit_2.`Q_39` as pnc2_Q_39,
     pnc_visit_2.`Q_40` as pnc2_Q_40,
     pnc_visit_2.`Q_41` as pnc2_Q_41,
     pnc_visit_2.`Q_43` as pnc2_Q_43,
     pnc_visit_2.`Q_44` as pnc2_Q_44,
     pnc_visit_2.`Q_45` as pnc2_Q_45,
     pnc_visit_2.`Q_46` as pnc2_Q_46,
     pnc_visit_2.`Q_47` as pnc2_Q_47,
     pnc_visit_2.`Q_48` as pnc2_Q_48,
     pnc_visit_2.`Q_49` as pnc2_Q_49,
     pnc_visit_2.`Q_50` as pnc2_Q_50,
     pnc_visit_2.`Q_52` as pnc2_Q_52,
     pnc_visit_2.`Q_53` as pnc2_Q_53,
     pnc_visit_2.`Q_54` as pnc2_Q_54,
     pnc_visit_2.`Q_55` as pnc2_Q_55,
     pnc_visit_2.`Q_56` as pnc2_Q_56,
     pnc_visit_2.`Q_57` as pnc2_Q_57,
     pnc_visit_2.`Q_58` as pnc2_Q_58,
     pnc_visit_2.`Q_59` as pnc2_Q_59,
     pnc_visit_2.`Q_60` as pnc2_Q_60,
     pnc_visit_2.`CreatedBy` as pnc2_CreatedBy,
     pnc_visit_2.`CreatedOn` as pnc2_CreatedOn,
     pnc_visit_2.`UpdatedBy` as pnc2_UpdatedBy,
     pnc_visit_2.`UpdatedOn` as pnc2_UpdatedOn,
     pnc_visit_2.`IsDeleted` as pnc2_IsDeleted,
     pnc_visit_2.`IsEdited` as pnc2_IsEdited,
     pnc_visit_2.`Q_38A` as pnc2_Q_38A,
     pnc_visit_2.`AshaID` as pnc2_AshaID,
     pnc_visit_2.`ANMID` as pnc2_ANMID,
     pnc_visit_3.`UID` as pnc3_UID,
     pnc_visit_3.`PWGUID` as pnc3_PWGUID,
     pnc_visit_3.`ChildGUID` as pnc3_ChildGUID,
     pnc_visit_3.`PNCGUID` as pnc3_PNCGUID,
     pnc_visit_3.`VisitNo` as pnc3_VisitNo,
     pnc_visit_3.`Q_0` as pnc3_Q_0,
     pnc_visit_3.`Q_1` as pnc3_Q_1,
     pnc_visit_3.`Q_2` as pnc3_Q_2,
     pnc_visit_3.`Q_3` as pnc3_Q_3,
     pnc_visit_3.`Q_4` as pnc3_Q_4,
     pnc_visit_3.`Q_5` as pnc3_Q_5,
     pnc_visit_3.`Q_6` as pnc3_Q_6,
     pnc_visit_3.`Q_7` as pnc3_Q_7,
     pnc_visit_3.`Q_8` as pnc3_Q_8,
     pnc_visit_3.`Q_9` as pnc3_Q_9,
     pnc_visit_3.`Q_10` as pnc3_Q_10,
     pnc_visit_3.`Q_12` as pnc3_Q_12,
     pnc_visit_3.`Q_13` as pnc3_Q_13,
     pnc_visit_3.`Q_14` as pnc3_Q_14,
     pnc_visit_3.`Q_15` as pnc3_Q_15,
     pnc_visit_3.`Q_16` as pnc3_Q_16,
     pnc_visit_3.`Q_17` as pnc3_Q_17,
     pnc_visit_3.`Q_18` as pnc3_Q_18,
     pnc_visit_3.`Q_19` as pnc3_Q_19,
     pnc_visit_3.`Q_20` as pnc3_Q_20,
     pnc_visit_3.`Q_21` as pnc3_Q_21,
     pnc_visit_3.`Q_22` as pnc3_Q_22,
     pnc_visit_3.`Q_23` as pnc3_Q_23,
     pnc_visit_3.`Q_24` as pnc3_Q_24,
     pnc_visit_3.`Q_25` as pnc3_Q_25,
     pnc_visit_3.`Q_26` as pnc3_Q_26,
     pnc_visit_3.`Q_27` as pnc3_Q_27,
     pnc_visit_3.`Q_28` as pnc3_Q_28,
     pnc_visit_3.`Q_29` as pnc3_Q_29,
     pnc_visit_3.`Q_30` as pnc3_Q_30,
     pnc_visit_3.`Q_32` as pnc3_Q_32,
     pnc_visit_3.`Q_33` as pnc3_Q_33,
     pnc_visit_3.`Q_34` as pnc3_Q_34,
     pnc_visit_3.`Q_35` as pnc3_Q_35,
     pnc_visit_3.`Q_36` as pnc3_Q_36,
     pnc_visit_3.`Q_37` as pnc3_Q_37,
     pnc_visit_3.`Q_38` as pnc3_Q_38,
     pnc_visit_3.`Q_39` as pnc3_Q_39,
     pnc_visit_3.`Q_40` as pnc3_Q_40,
     pnc_visit_3.`Q_41` as pnc3_Q_41,
     pnc_visit_3.`Q_43` as pnc3_Q_43,
     pnc_visit_3.`Q_44` as pnc3_Q_44,
     pnc_visit_3.`Q_45` as pnc3_Q_45,
     pnc_visit_3.`Q_46` as pnc3_Q_46,
     pnc_visit_3.`Q_47` as pnc3_Q_47,
     pnc_visit_3.`Q_48` as pnc3_Q_48,
     pnc_visit_3.`Q_49` as pnc3_Q_49,
     pnc_visit_3.`Q_50` as pnc3_Q_50,
     pnc_visit_3.`Q_52` as pnc3_Q_52,
     pnc_visit_3.`Q_53` as pnc3_Q_53,
     pnc_visit_3.`Q_54` as pnc3_Q_54,
     pnc_visit_3.`Q_55` as pnc3_Q_55,
     pnc_visit_3.`Q_56` as pnc3_Q_56,
     pnc_visit_3.`Q_57` as pnc3_Q_57,
     pnc_visit_3.`Q_58` as pnc3_Q_58,
     pnc_visit_3.`Q_59` as pnc3_Q_59,
     pnc_visit_3.`Q_60` as pnc3_Q_60,
     pnc_visit_3.`CreatedBy` as pnc3_CreatedBy,
     pnc_visit_3.`CreatedOn` as pnc3_CreatedOn,
     pnc_visit_3.`UpdatedBy` as pnc3_UpdatedBy,
     pnc_visit_3.`UpdatedOn` as pnc3_UpdatedOn,
     pnc_visit_3.`IsDeleted` as pnc3_IsDeleted,
     pnc_visit_3.`IsEdited` as pnc3_IsEdited,
     pnc_visit_3.`Q_38A` as pnc3_Q_38A,
     pnc_visit_3.`AshaID` as pnc3_AshaID,
     pnc_visit_3.`ANMID` as pnc3_ANMID,
     pnc_visit_4.`UID` as pnc4_UID,
     pnc_visit_4.`PWGUID` as pnc4_PWGUID,
     pnc_visit_4.`ChildGUID` as pnc4_ChildGUID,
     pnc_visit_4.`PNCGUID` as pnc4_PNCGUID,
     pnc_visit_4.`VisitNo` as pnc4_VisitNo,
     pnc_visit_4.`Q_0` as pnc4_Q_0,
     pnc_visit_4.`Q_1` as pnc4_Q_1,
     pnc_visit_4.`Q_2` as pnc4_Q_2,
     pnc_visit_4.`Q_3` as pnc4_Q_3,
     pnc_visit_4.`Q_4` as pnc4_Q_4,
     pnc_visit_4.`Q_5` as pnc4_Q_5,
     pnc_visit_4.`Q_6` as pnc4_Q_6,
     pnc_visit_4.`Q_7` as pnc4_Q_7,
     pnc_visit_4.`Q_8` as pnc4_Q_8,
     pnc_visit_4.`Q_9` as pnc4_Q_9,
     pnc_visit_4.`Q_10` as pnc4_Q_10,
     pnc_visit_4.`Q_12` as pnc4_Q_12,
     pnc_visit_4.`Q_13` as pnc4_Q_13,
     pnc_visit_4.`Q_14` as pnc4_Q_14,
     pnc_visit_4.`Q_15` as pnc4_Q_15,
     pnc_visit_4.`Q_16` as pnc4_Q_16,
     pnc_visit_4.`Q_17` as pnc4_Q_17,
     pnc_visit_4.`Q_18` as pnc4_Q_18,
     pnc_visit_4.`Q_19` as pnc4_Q_19,
     pnc_visit_4.`Q_20` as pnc4_Q_20,
     pnc_visit_4.`Q_21` as pnc4_Q_21,
     pnc_visit_4.`Q_22` as pnc4_Q_22,
     pnc_visit_4.`Q_23` as pnc4_Q_23,
     pnc_visit_4.`Q_24` as pnc4_Q_24,
     pnc_visit_4.`Q_25` as pnc4_Q_25,
     pnc_visit_4.`Q_26` as pnc4_Q_26,
     pnc_visit_4.`Q_27` as pnc4_Q_27,
     pnc_visit_4.`Q_28` as pnc4_Q_28,
     pnc_visit_4.`Q_29` as pnc4_Q_29,
     pnc_visit_4.`Q_30` as pnc4_Q_30,
     pnc_visit_4.`Q_32` as pnc4_Q_32,
     pnc_visit_4.`Q_33` as pnc4_Q_33,
     pnc_visit_4.`Q_34` as pnc4_Q_34,
     pnc_visit_4.`Q_35` as pnc4_Q_35,
     pnc_visit_4.`Q_36` as pnc4_Q_36,
     pnc_visit_4.`Q_37` as pnc4_Q_37,
     pnc_visit_4.`Q_38` as pnc4_Q_38,
     pnc_visit_4.`Q_39` as pnc4_Q_39,
     pnc_visit_4.`Q_40` as pnc4_Q_40,
     pnc_visit_4.`Q_41` as pnc4_Q_41,
     pnc_visit_4.`Q_43` as pnc4_Q_43,
     pnc_visit_4.`Q_44` as pnc4_Q_44,
     pnc_visit_4.`Q_45` as pnc4_Q_45,
     pnc_visit_4.`Q_46` as pnc4_Q_46,
     pnc_visit_4.`Q_47` as pnc4_Q_47,
     pnc_visit_4.`Q_48` as pnc4_Q_48,
     pnc_visit_4.`Q_49` as pnc4_Q_49,
     pnc_visit_4.`Q_50` as pnc4_Q_50,
     pnc_visit_4.`Q_52` as pnc4_Q_52,
     pnc_visit_4.`Q_53` as pnc4_Q_53,
     pnc_visit_4.`Q_54` as pnc4_Q_54,
     pnc_visit_4.`Q_55` as pnc4_Q_55,
     pnc_visit_4.`Q_56` as pnc4_Q_56,
     pnc_visit_4.`Q_57` as pnc4_Q_57,
     pnc_visit_4.`Q_58` as pnc4_Q_58,
     pnc_visit_4.`Q_59` as pnc4_Q_59,
     pnc_visit_4.`Q_60` as pnc4_Q_60,
     pnc_visit_4.`CreatedBy` as pnc4_CreatedBy,
     pnc_visit_4.`CreatedOn` as pnc4_CreatedOn,
     pnc_visit_4.`UpdatedBy` as pnc4_UpdatedBy,
     pnc_visit_4.`UpdatedOn` as pnc4_UpdatedOn,
     pnc_visit_4.`IsDeleted` as pnc4_IsDeleted,
     pnc_visit_4.`IsEdited` as pnc4_IsEdited,
     pnc_visit_4.`Q_38A` as pnc4_Q_38A,
     pnc_visit_4.`AshaID` as pnc4_AshaID,
     pnc_visit_4.`ANMID` as pnc4_ANMID,
     pnc_visit_5.`UID` as pnc5_UID,
     pnc_visit_5.`PWGUID` as pnc5_PWGUID,
     pnc_visit_5.`ChildGUID` as pnc5_ChildGUID,
     pnc_visit_5.`PNCGUID` as pnc5_PNCGUID,
     pnc_visit_5.`VisitNo` as pnc5_VisitNo,
     pnc_visit_5.`Q_0` as pnc5_Q_0,
     pnc_visit_5.`Q_1` as pnc5_Q_1,
     pnc_visit_5.`Q_2` as pnc5_Q_2,
     pnc_visit_5.`Q_3` as pnc5_Q_3,
     pnc_visit_5.`Q_4` as pnc5_Q_4,
     pnc_visit_5.`Q_5` as pnc5_Q_5,
     pnc_visit_5.`Q_6` as pnc5_Q_6,
     pnc_visit_5.`Q_7` as pnc5_Q_7,
     pnc_visit_5.`Q_8` as pnc5_Q_8,
     pnc_visit_5.`Q_9` as pnc5_Q_9,
     pnc_visit_5.`Q_10` as pnc5_Q_10,
     pnc_visit_5.`Q_12` as pnc5_Q_12,
     pnc_visit_5.`Q_13` as pnc5_Q_13,
     pnc_visit_5.`Q_14` as pnc5_Q_14,
     pnc_visit_5.`Q_15` as pnc5_Q_15,
     pnc_visit_5.`Q_16` as pnc5_Q_16,
     pnc_visit_5.`Q_17` as pnc5_Q_17,
     pnc_visit_5.`Q_18` as pnc5_Q_18,
     pnc_visit_5.`Q_19` as pnc5_Q_19,
     pnc_visit_5.`Q_20` as pnc5_Q_20,
     pnc_visit_5.`Q_21` as pnc5_Q_21,
     pnc_visit_5.`Q_22` as pnc5_Q_22,
     pnc_visit_5.`Q_23` as pnc5_Q_23,
     pnc_visit_5.`Q_24` as pnc5_Q_24,
     pnc_visit_5.`Q_25` as pnc5_Q_25,
     pnc_visit_5.`Q_26` as pnc5_Q_26,
     pnc_visit_5.`Q_27` as pnc5_Q_27,
     pnc_visit_5.`Q_28` as pnc5_Q_28,
     pnc_visit_5.`Q_29` as pnc5_Q_29,
     pnc_visit_5.`Q_30` as pnc5_Q_30,
     pnc_visit_5.`Q_32` as pnc5_Q_32,
     pnc_visit_5.`Q_33` as pnc5_Q_33,
     pnc_visit_5.`Q_34` as pnc5_Q_34,
     pnc_visit_5.`Q_35` as pnc5_Q_35,
     pnc_visit_5.`Q_36` as pnc5_Q_36,
     pnc_visit_5.`Q_37` as pnc5_Q_37,
     pnc_visit_5.`Q_38` as pnc5_Q_38,
     pnc_visit_5.`Q_39` as pnc5_Q_39,
     pnc_visit_5.`Q_40` as pnc5_Q_40,
     pnc_visit_5.`Q_41` as pnc5_Q_41,
     pnc_visit_5.`Q_43` as pnc5_Q_43,
     pnc_visit_5.`Q_44` as pnc5_Q_44,
     pnc_visit_5.`Q_45` as pnc5_Q_45,
     pnc_visit_5.`Q_46` as pnc5_Q_46,
     pnc_visit_5.`Q_47` as pnc5_Q_47,
     pnc_visit_5.`Q_48` as pnc5_Q_48,
     pnc_visit_5.`Q_49` as pnc5_Q_49,
     pnc_visit_5.`Q_50` as pnc5_Q_50,
     pnc_visit_5.`Q_52` as pnc5_Q_52,
     pnc_visit_5.`Q_53` as pnc5_Q_53,
     pnc_visit_5.`Q_54` as pnc5_Q_54,
     pnc_visit_5.`Q_55` as pnc5_Q_55,
     pnc_visit_5.`Q_56` as pnc5_Q_56,
     pnc_visit_5.`Q_57` as pnc5_Q_57,
     pnc_visit_5.`Q_58` as pnc5_Q_58,
     pnc_visit_5.`Q_59` as pnc5_Q_59,
     pnc_visit_5.`Q_60` as pnc5_Q_60,
     pnc_visit_5.`CreatedBy` as pnc5_CreatedBy,
     pnc_visit_5.`CreatedOn` as pnc5_CreatedOn,
     pnc_visit_5.`UpdatedBy` as pnc5_UpdatedBy,
     pnc_visit_5.`UpdatedOn` as pnc5_UpdatedOn,
     pnc_visit_5.`IsDeleted` as pnc5_IsDeleted,
     pnc_visit_5.`IsEdited` as pnc5_IsEdited,
     pnc_visit_5.`Q_38A` as pnc5_Q_38A,
     pnc_visit_5.`AshaID` as pnc5_AshaID,
     pnc_visit_5.`ANMID` as pnc5_ANMID,
     pnc_visit_6.`UID` as pnc6_UID,
     pnc_visit_6.`PWGUID` as pnc6_PWGUID,
     pnc_visit_6.`ChildGUID` as pnc6_ChildGUID,
     pnc_visit_6.`PNCGUID` as pnc6_PNCGUID,
     pnc_visit_6.`VisitNo` as pnc6_VisitNo,
     pnc_visit_6.`Q_0` as pnc6_Q_0,
     pnc_visit_6.`Q_1` as pnc6_Q_1,
     pnc_visit_6.`Q_2` as pnc6_Q_2,
     pnc_visit_6.`Q_3` as pnc6_Q_3,
     pnc_visit_6.`Q_4` as pnc6_Q_4,
     pnc_visit_6.`Q_5` as pnc6_Q_5,
     pnc_visit_6.`Q_6` as pnc6_Q_6,
     pnc_visit_6.`Q_7` as pnc6_Q_7,
     pnc_visit_6.`Q_8` as pnc6_Q_8,
     pnc_visit_6.`Q_9` as pnc6_Q_9,
     pnc_visit_6.`Q_10` as pnc6_Q_10,
     pnc_visit_6.`Q_12` as pnc6_Q_12,
     pnc_visit_6.`Q_13` as pnc6_Q_13,
     pnc_visit_6.`Q_14` as pnc6_Q_14,
     pnc_visit_6.`Q_15` as pnc6_Q_15,
     pnc_visit_6.`Q_16` as pnc6_Q_16,
     pnc_visit_6.`Q_17` as pnc6_Q_17,
     pnc_visit_6.`Q_18` as pnc6_Q_18,
     pnc_visit_6.`Q_19` as pnc6_Q_19,
     pnc_visit_6.`Q_20` as pnc6_Q_20,
     pnc_visit_6.`Q_21` as pnc6_Q_21,
     pnc_visit_6.`Q_22` as pnc6_Q_22,
     pnc_visit_6.`Q_23` as pnc6_Q_23,
     pnc_visit_6.`Q_24` as pnc6_Q_24,
     pnc_visit_6.`Q_25` as pnc6_Q_25,
     pnc_visit_6.`Q_26` as pnc6_Q_26,
     pnc_visit_6.`Q_27` as pnc6_Q_27,
     pnc_visit_6.`Q_28` as pnc6_Q_28,
     pnc_visit_6.`Q_29` as pnc6_Q_29,
     pnc_visit_6.`Q_30` as pnc6_Q_30,
     pnc_visit_6.`Q_32` as pnc6_Q_32,
     pnc_visit_6.`Q_33` as pnc6_Q_33,
     pnc_visit_6.`Q_34` as pnc6_Q_34,
     pnc_visit_6.`Q_35` as pnc6_Q_35,
     pnc_visit_6.`Q_36` as pnc6_Q_36,
     pnc_visit_6.`Q_37` as pnc6_Q_37,
     pnc_visit_6.`Q_38` as pnc6_Q_38,
     pnc_visit_6.`Q_39` as pnc6_Q_39,
     pnc_visit_6.`Q_40` as pnc6_Q_40,
     pnc_visit_6.`Q_41` as pnc6_Q_41,
     pnc_visit_6.`Q_43` as pnc6_Q_43,
     pnc_visit_6.`Q_44` as pnc6_Q_44,
     pnc_visit_6.`Q_45` as pnc6_Q_45,
     pnc_visit_6.`Q_46` as pnc6_Q_46,
     pnc_visit_6.`Q_47` as pnc6_Q_47,
     pnc_visit_6.`Q_48` as pnc6_Q_48,
     pnc_visit_6.`Q_49` as pnc6_Q_49,
     pnc_visit_6.`Q_50` as pnc6_Q_50,
     pnc_visit_6.`Q_52` as pnc6_Q_52,
     pnc_visit_6.`Q_53` as pnc6_Q_53,
     pnc_visit_6.`Q_54` as pnc6_Q_54,
     pnc_visit_6.`Q_55` as pnc6_Q_55,
     pnc_visit_6.`Q_56` as pnc6_Q_56,
     pnc_visit_6.`Q_57` as pnc6_Q_57,
     pnc_visit_6.`Q_58` as pnc6_Q_58,
     pnc_visit_6.`Q_59` as pnc6_Q_59,
     pnc_visit_6.`Q_60` as pnc6_Q_60,
     pnc_visit_6.`CreatedBy` as pnc6_CreatedBy,
     pnc_visit_6.`CreatedOn` as pnc6_CreatedOn,
     pnc_visit_6.`UpdatedBy` as pnc6_UpdatedBy,
     pnc_visit_6.`UpdatedOn` as pnc6_UpdatedOn,
     pnc_visit_6.`IsDeleted` as pnc6_IsDeleted,
     pnc_visit_6.`IsEdited` as pnc6_IsEdited,
     pnc_visit_6.`Q_38A` as pnc6_Q_38A,
     pnc_visit_6.`AshaID` as pnc6_AshaID,
     pnc_visit_6.`ANMID` as pnc6_ANMID,
     pnc_visit_7.`UID` as pnc7_UID,
     pnc_visit_7.`PWGUID` as pnc7_PWGUID,
     pnc_visit_7.`ChildGUID` as pnc7_ChildGUID,
     pnc_visit_7.`PNCGUID` as pnc7_PNCGUID,
     pnc_visit_7.`VisitNo` as pnc7_VisitNo,
     pnc_visit_7.`Q_0` as pnc7_Q_0,
     pnc_visit_7.`Q_1` as pnc7_Q_1,
     pnc_visit_7.`Q_2` as pnc7_Q_2,
     pnc_visit_7.`Q_3` as pnc7_Q_3,
     pnc_visit_7.`Q_4` as pnc7_Q_4,
     pnc_visit_7.`Q_5` as pnc7_Q_5,
     pnc_visit_7.`Q_6` as pnc7_Q_6,
     pnc_visit_7.`Q_7` as pnc7_Q_7,
     pnc_visit_7.`Q_8` as pnc7_Q_8,
     pnc_visit_7.`Q_9` as pnc7_Q_9,
     pnc_visit_7.`Q_10` as pnc7_Q_10,
     pnc_visit_7.`Q_12` as pnc7_Q_12,
     pnc_visit_7.`Q_13` as pnc7_Q_13,
     pnc_visit_7.`Q_14` as pnc7_Q_14,
     pnc_visit_7.`Q_15` as pnc7_Q_15,
     pnc_visit_7.`Q_16` as pnc7_Q_16,
     pnc_visit_7.`Q_17` as pnc7_Q_17,
     pnc_visit_7.`Q_18` as pnc7_Q_18,
     pnc_visit_7.`Q_19` as pnc7_Q_19,
     pnc_visit_7.`Q_20` as pnc7_Q_20,
     pnc_visit_7.`Q_21` as pnc7_Q_21,
     pnc_visit_7.`Q_22` as pnc7_Q_22,
     pnc_visit_7.`Q_23` as pnc7_Q_23,
     pnc_visit_7.`Q_24` as pnc7_Q_24,
     pnc_visit_7.`Q_25` as pnc7_Q_25,
     pnc_visit_7.`Q_26` as pnc7_Q_26,
     pnc_visit_7.`Q_27` as pnc7_Q_27,
     pnc_visit_7.`Q_28` as pnc7_Q_28,
     pnc_visit_7.`Q_29` as pnc7_Q_29,
     pnc_visit_7.`Q_30` as pnc7_Q_30,
     pnc_visit_7.`Q_32` as pnc7_Q_32,
     pnc_visit_7.`Q_33` as pnc7_Q_33,
     pnc_visit_7.`Q_34` as pnc7_Q_34,
     pnc_visit_7.`Q_35` as pnc7_Q_35,
     pnc_visit_7.`Q_36` as pnc7_Q_36,
     pnc_visit_7.`Q_37` as pnc7_Q_37,
     pnc_visit_7.`Q_38` as pnc7_Q_38,
     pnc_visit_7.`Q_39` as pnc7_Q_39,
     pnc_visit_7.`Q_40` as pnc7_Q_40,
     pnc_visit_7.`Q_41` as pnc7_Q_41,
     pnc_visit_7.`Q_43` as pnc7_Q_43,
     pnc_visit_7.`Q_44` as pnc7_Q_44,
     pnc_visit_7.`Q_45` as pnc7_Q_45,
     pnc_visit_7.`Q_46` as pnc7_Q_46,
     pnc_visit_7.`Q_47` as pnc7_Q_47,
     pnc_visit_7.`Q_48` as pnc7_Q_48,
     pnc_visit_7.`Q_49` as pnc7_Q_49,
     pnc_visit_7.`Q_50` as pnc7_Q_50,
     pnc_visit_7.`Q_52` as pnc7_Q_52,
     pnc_visit_7.`Q_53` as pnc7_Q_53,
     pnc_visit_7.`Q_54` as pnc7_Q_54,
     pnc_visit_7.`Q_55` as pnc7_Q_55,
     pnc_visit_7.`Q_56` as pnc7_Q_56,
     pnc_visit_7.`Q_57` as pnc7_Q_57,
     pnc_visit_7.`Q_58` as pnc7_Q_58,
     pnc_visit_7.`Q_59` as pnc7_Q_59,
     pnc_visit_7.`Q_60` as pnc7_Q_60,
     pnc_visit_7.`CreatedBy` as pnc7_CreatedBy,
     pnc_visit_7.`CreatedOn` as pnc7_CreatedOn,
     pnc_visit_7.`UpdatedBy` as pnc7_UpdatedBy,
     pnc_visit_7.`UpdatedOn` as pnc7_UpdatedOn,
     pnc_visit_7.`IsDeleted` as pnc7_IsDeleted,
     pnc_visit_7.`IsEdited` as pnc7_IsEdited,
     pnc_visit_7.`Q_38A` as pnc7_Q_38A,
     pnc_visit_7.`AshaID` as pnc7_AshaID,
     pnc_visit_7.`ANMID` as pnc7_ANMID,
     child.`pw_GUID` as child_pw_GUID,
     child.`child_id` as child_child_id,
     child.`childGUID` as child_childGUID,
     child.`motherGUID` as child_motherGUID,
     child.`Date_Of_Registration` as child_Date_Of_Registration,
     child.`child_dob` as child_child_dob,
     child.`birth_time` as child_birth_time,
     child.`Gender` as child_Gender,
     child.`Wt_of_child` as child_Wt_of_child,
     child.`place_of_birth` as child_place_of_birth,
     child.`preTerm_fullTerm` as child_preTerm_fullTerm,
     child.`mother_status` as child_mother_status,
     child.`child_status` as child_child_status,
     child.`mother_death_dt` as child_mother_death_dt,
     child.`child_death_dt` as child_child_death_dt,
     child.`child_mcts_id` as child_child_mcts_id,
     child.`child_name` as child_child_name,
     child.`cried_after_birth` as child_cried_after_birth,
     child.`breastfeeding_within1H` as child_breastfeeding_within1H,
     child.`Exclusive_BF` as child_Exclusive_BF,
     child.`complementry_BF` as child_complementry_BF,
     child.`bcg` as child_bcg,
     child.`opv1` as child_opv1,
     child.`dpt1` as child_dpt1,
     child.`hepb1` as child_hepb1,
     child.`opv2` as child_opv2,
     child.`dpt2` as child_dpt2,
     child.`hepb2` as child_hepb2,
     child.`opv3` as child_opv3,
     child.`dpt3` as child_dpt3,
     child.`hepb3` as child_hepb3,
     child.`measeals` as child_measeals,
     child.`vitaminA` as child_vitaminA,
     child.`FacilityType` as child_FacilityType,
     child.`Facility` as child_Facility,
     child.`opv4` as child_opv4,
     child.`hepb4` as child_hepb4,
     child.`Pentavalent1` as child_Pentavalent1,
     child.`Pentavalent2` as child_Pentavalent2,
     child.`Pentavalent3` as child_Pentavalent3,
     child.`IPV` as child_IPV,
     child.`DPTBooster` as child_DPTBooster,
     child.`OPVBooster` as child_OPVBooster,
     child.`MeaslesTwoDose` as child_MeaslesTwoDose,
     child.`VitaminAtwo` as child_VitaminAtwo,
     child.`DPTBoostertwo` as child_DPTBoostertwo,
     child.`ChildTT` as child_ChildTT,
     child.`JEVaccine1` as child_JEVaccine1,
     child.`JEVaccine2` as child_JEVaccine2,
     child.`VitaminA3` as child_VitaminA3,
     child.`VitaminA4` as child_VitaminA4,
     child.`VitaminA5` as child_VitaminA5,
     child.`VitaminA6` as child_VitaminA6,
     child.`VitaminA7` as child_VitaminA7,
     child.`VitaminA8` as child_VitaminA8,
     child.`VitaminA9` as child_VitaminA9,
     child.`TT2` as child_TT2,
     immu.`Q1` as immu_Q1,
     immu.`Q2` as immu_Q2,
     immu.`Q3` as immu_Q3,
     immu.`Q4` as immu_Q4,
     immu.`Q5` as immu_Q5,
     immu.`Q6` as immu_Q6,
     immu.`Q7` as immu_Q7,
     immu.`Q14` as immu_Q14,
     immu.`Q25` as immu_Q25,
     immu.`Q36` as immu_Q36,
     immu.`Q47` as immu_Q47,
     immu.`ImmunizationGUID` as immu_ImmunizationGUID,
     immu.`ChildGUID` as immu_ChildGUID,
     immu.`Q53` as immu_Q53,
     immu.`TimeDuration` as immu_TimeDuration,
     immu.`Q13` as immu_Q13,
     immu.`Q21` as immu_Q21,
     immu.`Q22` as immu_Q22,
     immu.`Q24` as immu_Q24,
     immu.`Q27` as immu_Q27,
     immu.`Q37` as immu_Q37,
     immu.`Q45` as immu_Q45,
     immu.`Q51` as immu_Q51,
     immu.`Q61` as immu_Q61,
     immu.`Q70` as immu_Q70,
     immu.`Q73` as immu_Q73,
     immu.`Q75` as immu_Q75,
     immu.`Q85` as immu_Q85,
     immu.`Q86` as immu_Q86,
     immu.`Q94` as immu_Q94,
     immu.`Q111` as immu_Q111,
     immu.`Q112` as immu_Q112,
     immu.`Q117` as immu_Q117,
     immu.`Q124` as immu_Q124,
     immu.`Q125` as immu_Q125,
     immu.`Q46` as immu_Q46,
     immu.`Q146` as immu_Q146,
     immu.`Q69` as immu_Q69,
     immu.`Q48` as immu_Q48,
     immu.`Q145` as immu_Q145,
     immu.`Q148` as immu_Q148
     FROM
     `tblpregnant_woman` preg_woman
     INNER JOIN tblhhsurvey hh ON
     preg_woman.hhguid = hh.HHSurveyGUID
     INNER JOIN tblhhfamilymember fm ON
     preg_woman.hhfamilymemberguid = fm.HHFamilyMemberGUID
     LEFT JOIN(
     SELECT *
     FROM
     `tblancvisit`
     WHERE
     Visit_No = 1
     ) anc_visit_1
     ON
     preg_woman.pwguid = anc_visit_1.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblancvisit`
     WHERE
     Visit_No = 2
     ) anc_visit_2
     ON
     preg_woman.pwguid = anc_visit_2.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblancvisit`
     WHERE
     Visit_No = 3
     ) anc_visit_3
     ON
     preg_woman.pwguid = anc_visit_3.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblancvisit`
     WHERE
     Visit_No = 4
     ) anc_visit_4
     ON
     preg_woman.pwguid = anc_visit_4.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 1
     ) pnc_visit_1
     ON
     preg_woman.pwguid = pnc_visit_1.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 2
     ) pnc_visit_2
     ON
     preg_woman.pwguid = pnc_visit_2.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 3
     ) pnc_visit_3
     ON
     preg_woman.pwguid = pnc_visit_3.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 4
     ) pnc_visit_4
     ON
     preg_woman.pwguid = pnc_visit_4.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 5
     ) pnc_visit_5
     ON
     preg_woman.pwguid = pnc_visit_5.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 6
     ) pnc_visit_6
     ON
     preg_woman.pwguid = pnc_visit_6.pwguid
     LEFT JOIN(
     SELECT *
     FROM
     `tblpnchomevisit_ans`
     WHERE
     VisitNo = 7
     ) pnc_visit_7
     ON
     preg_woman.pwguid = pnc_visit_7.pwguid
     left join  `tblchild` child on preg_woman.PWGUID = child.pw_guid
     LEFT join tblmstimmunizationans immu on child.childguid = immu.ChildGUID
     where preg_woman.pwguid is not null
     order by preg_woman.pwguid,preg_woman.createdon";

     $this->load->model('Data_export_model');
     $this->Data_export_model->export_csv($query);
}

public function list_options()
{
    $content['subview'] = 'list_export_options';
    $this->load->view('auth/main_layout', $content);
} 

public function export_user_register()
{
    $query = "SELECT * FROM `user_register_with_af`";
    $this->load->model('Data_export_model');
    print_r($query); die();
    $this->Data_export_model->export_csv($query);
}


public function export_family_data()
{
    $query = "select a.HHCode, a.StateCode, b.* from tblhhsurvey a inner join tblhhfamilymember b on a.HHSurveyGUID = b.HHSurveyGUID";
    $this->load->model('Data_export_model');
    print_r($query); die();
    $this->Data_export_model->export_csv($query);   
}

public function export_demographic_population_ashawise()
{
     $query = "select
     a.ASHAName,
     a.ASHACode,
     c.user_name,
     ifnull(d.total,0) AS total_hh,
     ifnull(e.total,0) AS total_familymember,
     ifnull(f.total,0) AS total_preg,
     ifnull(g.total,0) AS women_15_49,
     ifnull(h.total,0) AS children_0_5_years,
     ifnull(i.total,0) AS adult_35_50_years,
     ifnull(j.total,0) AS adult_60_years,
     c.user_id,
     c.user_mode
     FROM (select * from tblusers where is_deleted=0 and user_mode = 1) c
     left join userashamapping b
     on b.UserID = c.user_id
     left join mstasha a ON
     a.ASHAID = b.AshaID AND a.LanguageID = 1 and a.IsActive=1
     LEFT JOIN(
     SELECT
     COUNT(*) AS total,
     CreatedBy
     FROM
     tblhhsurvey
     WHERE
     IsDeleted = 0
     GROUP BY
     CreatedBy
     ) d
     ON
     c.user_id = d.CreatedBy
     LEFT JOIN(
     SELECT
     COUNT(*) AS total,
     a.createdBy
     FROM
     tblhhfamilymember a 
     inner join tblhhsurvey b
     on a.HHSurveyGUID = b.HHSurveyGUID 
     where a.IsDeleted = 0 and b.IsDeleted = 0
     group by a.CreatedBy
     ) e
     ON
     c.user_id = e.CreatedBy
     LEFT JOIN(
     select count(*) as total,
     a.CreatedBy,
     c.VillageID
     from tblpregnant_woman a
     inner join tblhhfamilymember b
     on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
     inner join tblhhsurvey c
     on b.HHSurveyGUID = c.HHSurveyGUID
     where a.IsPregnant=1 and a.IsDeleted = 0 and b.IsDeleted = 0 and c.IsDeleted = 0
    
      group by a.CreatedBy
     ) f
     ON
     c.user_id = f.CreatedBy
     LEFT JOIN(
     SELECT
     COUNT(*) AS total,
     a.createdBy
     FROM
     tblhhfamilymember a
inner join tblhhsurvey b
     on a.HHSurveyGUID = b.HHSurveyGUID
     WHERE
     a.GenderID = 2 AND a.IsDeleted = 0 and b.IsDeleted = 0 AND a.MaritialStatusID = 1
and
     (
          CASE
          WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
          WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
     ) >= 15 and
     (
          CASE
          WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
          WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
     ) <=49
     group by a.CreatedBy
     ) g
     ON
     c.user_id = g.CreatedBy
     LEFT JOIN(
     select count(*) as total,
     a.created_by,
     c.VillageID
     from tblchild a
     inner join tblhhfamilymember b
     on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
     inner join tblhhsurvey c
     on b.HHSurveyGUID = c.HHSurveyGUID
     where a.IsDeleted = 0 and b.IsDeleted = 0 and c.IsDeleted = 0 and TIMESTAMPDIFF(MONTH,a.child_dob, CURRENT_DATE) <=60
     group by a.created_by
     ) h
     ON
     c.user_id = h.created_by
     LEFT JOIN(
     SELECT
     COUNT(*) AS total,
     a.createdBy, b.VillageID
     FROM
     tblhhfamilymember a
     inner join tblhhsurvey b
     on a.HHSurveyGUID = b.HHSurveyGUID
     WHERE
     (
          CASE
          WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
          WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
     ) >= 35 and
     (
          CASE
          WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
          WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
     ) <=50
     group by a.CreatedBy
     ) i
     ON
     c.user_id = i.CreatedBy
     LEFT JOIN(
     SELECT
     COUNT(*) AS total,
     a.createdBy, b.VillageID
     FROM
     tblhhfamilymember a
     inner join tblhhsurvey b
     on a.HHSurveyGUID = b.HHSurveyGUID
     WHERE a.IsDeleted = 0 and b.IsDeleted = 0 and
     (
          CASE
          WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
          WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
     ) >=60
     group by a.CreatedBy
     ) j
     ON
     c.user_id = j.CreatedBy
     where c.user_mode = 1";

     // print_r($query); die();
     
     $this->load->model('Data_export_model');
     print_r($query); die();
     $this->Data_export_model->export_csv($query);  
}

}