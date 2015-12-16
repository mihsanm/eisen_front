/// <reference path="libs/Promise.ts"/>

"use strict";

/**
 * Created by IT College on 2015/12/07.
 */
jQuery(function () {
    //topbarのメニューボタン
    jQuery('.menu-icon').click(function () {
        var navw = jQuery(".navigation").width();
        var popup = jQuery(this).parent().children('.menu-popup');
        if (jQuery(popup).css("display") == "none") {
            //menu-popupをすべて閉じる,popupの切替
            jQuery('.menu-popup').animate({height: "hide"}, {
                duration: 0,
                easing: "easeOutCubic"
            });
            //モバイル幅でnavigationが開いていた場合の処理
            if (window.matchMedia('(max-width: 480px)').matches && jQuery('.navigation').css("left") == "0px") {
                //navigationを閉じる
                jQuery('.navigation').animate({left: "-" + navw + "px"}, {
                    duration: 300,
                    easing: "easeOutCubic"
                });
            }
            //popupを開く
            jQuery(popup).css("display", "block");
        } else if (jQuery(popup).css("display") != "none") {
            //popupが表示されてたら閉じる
            jQuery(popup).css("display", "none");
        }
    });
    //左ナビゲーション
    jQuery('.navigation-toggle').click(function () {
        var navw = jQuery(".navigation").width();
        //css leftの位置で開閉を判定
        if (jQuery('.navigation').css("left") != "0px") {
            //	menu-popupをすべて閉じる モバイルで干渉するため
            jQuery('.menu-popup').css("display", "none");
            jQuery('.navigation').animate({left: "0px"}, {
                duration: 300,
                easing: "easeOutCubic"
            });
        } else if (jQuery('.navigation').css("left") == "0px") {
            jQuery('.navigation').animate({left: "-" + navw + "px"}, {
                duration: 300,
                easing: "easeOutCubic"
            });
        }
    });
    //ウィンドウ幅が切り替わった際のナビゲーション位置リセット
    jQuery(window).resize(function () {
        var navw = jQuery(".navigation").width();
        var w = jQuery(window).width();
        //innerwidthもある
        var mobile = 480;
        var desktop = 768;
        var navw = 200;
        if (w < mobile) {
            jQuery('.navigation').css("left", "-" + navw + "px");
        }
        if (w > mobile) {
            jQuery('.navigation').css("left", "0px");
        }
    });
    //モーダルウィンドウ関連
    //リサイズ時のモーダル位置を設定
    jQuery(window).resize(function () {
        //リサイズ対象の現在開かれているモーダル
        var resizetarget = '[data-modal-active="true"]';
        //モーダルの幅を取得
        var modalw = jQuery(resizetarget + '>' + ".modal-wrapper").outerWidth();
        //描画エリアの幅を取得(この要素を基準に中央寄せ)
        var areaw = jQuery(resizetarget).width();
        //positionの位置を計算
        var modalcenter = (areaw / 2) - (modalw / 2);
        jQuery(resizetarget + '>' + ".modal-wrapper").css("left", modalcenter + "px");
    });
    //モーダルの開閉
    jQuery('[data-modal="open"]').click(function () {
        //開きたいモーダルのID
        var target = '#' + jQuery(this).attr("data-modal-target");
        //開きたいモーダルに属性追加
        jQuery(target).attr({'data-modal-active': 'true'});
        //モーダルの初期位置を設定
        var modalw = jQuery(target + ">" + ".modal-wrapper").outerWidth();
        var areaw = jQuery(target).width();
        var modalcenter = (areaw / 2) - (modalw / 2);
        jQuery(target + '>' + ".modal-wrapper").css("left", modalcenter + "px");
        //モーダルを開く
        jQuery(target).css('visibility', 'visible').hide().fadeIn('0', 'easeOutCubic');
    });
    jQuery('[data-modal="close"]').click(function () {
        //開かれているモーダルを閉じる
        jQuery('[data-modal-active="true"]').fadeOut('0', 'easeOutCubic', function () {
            jQuery('[data-modal-active="true"]').css('visibility', 'hidden').css('display', 'block');
            jQuery('[data-modal-active="true"]' + '>' + ".modal-wrapper").css("left", "0px");
            jQuery('[data-modal-active="true"]').attr({'data-modal-active': 'false'});
        });
    });
    //リストのドロップダウンメニューテスト
    jQuery('.list-data-option-icon').click(function () {
        var target = jQuery(this).parent().children('.dropdown-menu');
        if (jQuery(target).css("display") == "none") {
            jQuery(target).css("display", "block");
        } else if (jQuery(target).css("display") != "none") {
            jQuery(target).css("display", "none");
        }
    });

    jQuery(document).on("click", ".cell-which-triggers-popup", function (event) {
        var cellValue1 = jQuery(event.target).closest('tr').find('.ipaddress').text();
        var cellValue2 = jQuery(event.target).closest('tr').find('.port').text();
        //console.log(cell_value);
        if (cellValue1 && cellValue2) {
            showPopup(cellValue1, cellValue2);
        }
    });

    function showPopup(cellValue1, cellValue2) {
        jQuery("#popup").dialog({
            width: 500,
            height: 300,
            open: function () {
                jQuery(this).find("p").html("<a href=host_list.php?host=" + cellValue1 + "\&action=" + cellValue2 + ">install " + cellValue1 + "</a>");
            }
        });
    }

    jQuery('#form1').submit(function (event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: 'includes/search.php',
            data: jQuery(this).serialize(),
            dataType: 'json',
            beforeSend: function () {
                jQuery('table#resultTable tbody').html("<tr><td></td><td><i class='fa fa-spinner fa-pulse fa-2x'></i></td></tr>");
            },
            success: function (data) {
                jQuery('table#resultTable tbody').html(data.msg);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                alert(xhr.responseText);
            }
        });
    });

    jQuery(document).ajaxComplete(function (event, xhr, settings) {
        jQuery(document).on("click", ".cell-which-triggers-popup", function (event) {
            var cellValue = jQuery(event.target).closest('tr').find('.item').text();
            if (cellValue) {
                showPopup(cellValue);
            }
        });

        function showPopup(cellValue) {
            jQuery("#popup").dialog({
                width: 500,
                height: 300,
                open: function () {
                    jQuery(this).find("p.item-1").html("<a href=includes/package_action/package_action.php?package=" + cellValue + "\&action=install\>Install " + cellValue + "\</a>");
                    jQuery(this).find("p.item-2").html("<a href=includes/package_action/package_action.php?package=" + cellValue + "\&action=update>Update " + cellValue + "\</a>");
                    jQuery(this).find("p.item-3").html("<a href=includes/package_action/package_action.php?package=" + cellValue + "\&action=delete>Delete " + cellValue + "\</a>");
                }
            });
        }
    });