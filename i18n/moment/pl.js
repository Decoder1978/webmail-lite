// moment.js language configuration
// language : polish (pl)
// author : Rafal Hirsz : https://github.com/evoL
(function(){function e(e){function t(e){return 5>e%10&&e%10>1&&1!==~~(e/10)}function a(e,a,n){var _=e+" ";switch(n){case"m":return a?"minuta":"minut\u0119";case"mm":return _+(t(e)?"minuty":"minut");case"h":return a?"godzina":"godzin\u0119";case"hh":return _+(t(e)?"godziny":"godzin");case"MM":return _+(t(e)?"miesi\u0105ce":"miesi\u0119cy");case"yy":return _+(t(e)?"lata":"lat")}}e.lang("pl",{months:"stycze\u0144_luty_marzec_kwiecie\u0144_maj_czerwiec_lipiec_sierpie\u0144_wrzesie\u0144_pa\u017adziernik_listopad_grudzie\u0144".split("_"),monthsShort:"sty_lut_mar_kwi_maj_cze_lip_sie_wrz_pa\u017a_lis_gru".split("_"),weekdays:"niedziela_poniedzia\u0142ek_wtorek_\u015broda_czwartek_pi\u0105tek_sobota".split("_"),weekdaysShort:"nie_pon_wt_\u015br_czw_pt_sb".split("_"),weekdaysMin:"N_Pn_Wt_\u015ar_Cz_Pt_So".split("_"),longDateFormat:{LT:"HH:mm",L:"DD-MM-YYYY",LL:"D MMMM YYYY",LLL:"D MMMM YYYY LT",LLLL:"dddd, D MMMM YYYY LT"},calendar:{sameDay:"[Dzi\u015b o] LT",nextDay:"[Jutro o] LT",nextWeek:"[W] dddd [o] LT",lastDay:"[Wczoraj o] LT",lastWeek:function(){switch(this.day()){case 0:return"[W zesz\u0142\u0105 niedziel\u0119 o] LT";case 3:return"[W zesz\u0142\u0105 \u015brod\u0119 o] LT";case 6:return"[W zesz\u0142\u0105 sobot\u0119 o] LT";default:return"[W zesz\u0142y] dddd [o] LT"}},sameElse:"L"},relativeTime:{future:"za %s",past:"%s temu",s:"kilka sekund",m:a,mm:a,h:a,hh:a,d:"1 dzie\u0144",dd:"%d dni",M:"miesi\u0105c",MM:a,y:"rok",yy:a},ordinal:"%d.",week:{dow:1,doy:4}})}"function"==typeof define&&define.amd&&define(["moment"],e),"undefined"!=typeof window&&window.moment&&e(window.moment)})();