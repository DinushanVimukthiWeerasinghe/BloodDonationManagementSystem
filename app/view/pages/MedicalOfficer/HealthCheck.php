<?php
/* @var Donor $Donor */

use App\model\MedicalTeam\TeamMembers;
use App\model\users\Donor;

?>

<div class="d-flex w-100 h-100 m-1 bg-white border-radius-10 align-items-center flex-column">
    <div class="d-flex text-xl font-bold bg-dark my-1 py-1 w-95 text-white text-center justify-content-center align-items-center">Health Checkup</div>
    <div class="d-flex w-100 overflow-y-scroll mb-2">
        <form action="" method="post" class="d-flex justify-content-between w-100">
            <input type="hidden" name="Task" value=<?=TeamMembers::TASK_HEALTH_CHECK?>>
            <input type="hidden" name="Donor_ID" value="<?=$Donor->getDonorID()?>">
            <div id="PreviousDonation" class="w-70 d-flex flex-column px-2 gap-1 ">
                <div class="form-group w-100">
                    <div class="form-group border-2 border-radius-10 border-dark px-2 py-0-5" style="gap: 0">
                        <label for="IsDonatedPreviously" class="w-70">Are you in Good Health?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end justify-content-end">
                            <input type="radio" name="GoodHealth" checked id="IsDonatedPreviouslyY" value=1 class="form-radio" required>
                            <label for="IsDonatedPreviouslyY" class="">Yes</label>
                            <input  type="radio" name="GoodHealth" id="IsDonatedPreviouslyN" value=2 class="form-radio" required>
                            <label for="IsDonatedPreviouslyN" class="">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group w-100">
                    <div class="form-group w-100 border-2 border-dark py-0-5 px-2 border-radius-10">
                        <label for="Disease" class="align-self-baseline w-40">Have You ever infected in following Disease?</label>
                        <div class="d-flex flex-column flex-wrap w-50 gap-1">
                            <div class="d-flex w-100 gap-1">
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Hepatitis" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Hepatitis</label>
                                </div>
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="HIV" class="form-checkbox">
                                    <label for="Disease" class="ml-2">HIV</label>
                                </div>
                            </div>
                            <div class="d-flex w-100 gap-1">
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Malaria" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Malaria</label>
                                </div>
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Tuberculosis" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Tuberculosis</label>
                                </div>
                            </div>
                            <div class="d-flex w-100 gap-1">
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Diabetes" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Diabetes</label>
                                </div>
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Cancer" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Cancer</label>
                                </div>
                            </div>
                            <div class="d-flex w-100 gap-1">
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Asthma" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Asthma</label>
                                </div>
                                <div class="w-50 d-flex align-items-center">
                                    <input type="checkbox" name="Disease[]" id="Disease" value="Heart Disease" class="form-checkbox">
                                    <label for="Disease" class="ml-2">Heart Disease</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                    <label for="PartnerAids" class="w-70">Do Your Partner infected in HIV AIDS?</label>
                    <div class="d-flex w-30 gap-1 justify-content-end">
                        <input type="radio" name="PartnerAids" id="PartnerAidsY" value=1 class="form-radio" required>
                        <label for="PartnerAidsY" class="">Yes</label>
                        <input  type="radio" name="PartnerAids" checked id="PartnerAidsN" value=2 class="form-radio" required>
                        <label for="PartnerAidsN" class="">No</label>
                    </div>
                </div>
                    <div class="d-flex text-xl font-bold">In Past 12 Months,</div>
                <div class="form-group flex-column w-100">
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Vaccine" class="w-70">Have You got a Vaccine?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Vaccinated" id="VaccineY" value=1 class="form-radio" required>
                            <label for="VaccineY" class="">Yes</label>
                            <input  type="radio" name="Vaccinated" checked id="VaccineN" value=2 class="form-radio" required>
                            <label for="VaccineN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Tattoo" class="w-70">Have You got a Tattoo?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Tattooed" id="TattooY" value=1 class="form-radio" required>
                            <label for="TattooY" class="">Yes</label>
                            <input  type="radio" checked name="Tattooed" id="TattooN" value=2 class="form-radio" required>
                            <label for="TattooN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Piercing" class="w-70">Have You got a Piercing?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Pierced" id="PiercingY" value=1 class="form-radio" required>
                            <label for="PiercingY" class="">Yes</label>
                            <input  type="radio" checked name="Pierced" id="PiercingN" value=2 class="form-radio" required>
                            <label for="PiercingN" class="">No</label>
                        </div>
                    </div>
<!--                TODO :    Check Gender Whether Female or Male-->
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Pregnant" class="w-70">Have You got Pregnant?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Pregnant" id="PregnantY" value=1 class="form-radio" required>
                            <label for="PregnantY" class="">Yes</label>
                            <input  type="radio" checked name="Pregnant" id="PregnantN" value=2 class="form-ra  dio" required>
                            <label for="PregnantN" class="">No</label>
                        </div>
                    </div>

                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Prisoned" class="w-70">Have You Prisoned?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Prisoned" id="PrisonedY" value=1 class="form-radio" required>
                            <label for="PrisonedY" class="">Yes</label>
                            <input  type="radio" name="Prisoned" checked id="PrisonedN" value=2 class="form-radio" required>
                            <label for="PrisonedN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Abroad" class="w-70">Have You or Your life partner Went Abroad?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Went_Abroad" id="AbroadY" value=1 class="form-radio" required>
                            <label for="AbroadY" class="">Yes</label>
                            <input  type="radio" name="Went_Abroad" checked id="AbroadN" value=2 class="form-radio" required>
                            <label for="AbroadN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="DonatePartner" class="w-70">Have You Donate Blood for your partner?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Donated_To_Partner" id="DonatePartnerY" value=1 class="form-radio" required>
                            <label for="DonatePartnerY" class="">Yes</label>
                            <input  type="radio" name="Donated_To_Partner" id="DonatePartnerN" checked value=2 class="form-radio" required>
                            <label for="DonatePartnerN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="InfectedMalaria" class="w-70">Have You Infected Malaria or Got treatment ?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Malaria_Infected" id="InfectedMalariaY" value=1 class="form-radio" required>
                            <label for="InfectedMalariaY" class="">Yes</label>
                            <input  type="radio" name="Malaria_Infected" checked id="InfectedMalariaN" value=2 class="form-radio" required>
                            <label for="InfectedMalariaN" class="">No</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-xl font-bold">In Past 6 Months,</div>
                <div class="form-group flex-column w-100">
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="InfectedDengue" class="w-70">Have You infected Dengue or got treatment ?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Dengue_Infected" id="InfectedDengueY" value=1 class="form-radio" required>
                            <label for="InfectedDengueY" class="">Yes</label>
                            <input  type="radio" name="Dengue_Infected" checked id="InfectedDengueN" value=2 class="form-radio" required>
                            <label for="InfectedDengueN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="InfectedChickenPoxAndOther" class="w-70">Have You infected  chickenpox , Mumps ,Measles ,Rubella Fever(German Measles), Diarrhea or Any Fever?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end align-items-center ">
                            <input type="radio" name="CFever_Infected" id="InfectedChickenPoxAndOtherY" value=1 class="form-radio" required>
                            <label for="InfectedChickenPoxAndOtherY" class="">Yes</label>
                            <input  type="radio" name="CFever_Infected" checked id="InfectedChickenPoxAndOtherN" value=2 class="form-radio" required>
                            <label for="InfectedChickenPoxAndOtherN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="RemoveTeeth" class="w-70">Have You removed any teeth?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Teeth_Removed" id="RemoveTeethY" value=1 class="form-radio" required>
                            <label for="RemoveTeethY" class="">Yes</label>
                            <input  type="radio" name="Teeth_Removed" checked id="RemoveTeethN" value=2 class="form-radio" required>
                            <label for="RemoveTeethN" class="">No</label>
                        </div>
                    </div>
                    <div class="d-flex w-100 border-2 border-dark px-2 py-0-5 border-radius-10">
                        <label for="Antibiotics" class="w-70">Have You got Antibiotics , Aspirin or any Medicine?</label>
                        <div class="d-flex w-30 gap-1 justify-content-end">
                            <input type="radio" name="Antibiotics_And_Aspirins" id="AntibioticsY" value=1 class="form-radio" required>
                            <label for="AntibioticsY" class="">Yes</label>
                            <input  type="radio" name="Antibiotics_And_Aspirins" checked id="AntibioticsN" value=2 class="form-radio" required>
                            <label for="AntibioticsN" class="">No</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </div>
            <div id="DonorDetails" class="w-30 d-flex flex-column mt-2 justify-content-start align-items-center px-2 gap-1">
                <div class="d-flex">
                    <img src="<?=$Donor->getProfileImage()?>" alt="Donor Details" width="250px" height="280px" style="object-fit: cover">
                </div>
                <div class="d-flex flex-column">
                    <div class="text-xl"><?=$Donor->getFullName()?></div>
                    <div class="text-xl"><?=$Donor->getNIC()?></div>
                </div>
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex flex-column gap-1">
                        <label for="PreviousDonationRemarks" class="text-xl text-center text-white bg-dark px-2 py-0-5">Previous Donation Remarks </label>
                        <textarea id="PreviousDonationRemarks" disabled class="text-sm" rows="3">No Remarks!</textarea>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label for="UnAvailabilityReason" class="text-xl text-center text-white bg-dark px-2 py-0-5">Unavailability Reason </label>
                        <textarea id="UnAvailabilityReason" disabled class="text-sm" rows="3">No Reason!</textarea>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

    </div>
</div>
