function Argo_Calendar() {
    // 初期化
//  <!-- %foreach $holiday as $key=>$val% -->
//  Argo_Calendar.holiday['<!-- %$key% -->'] = '<!-- %$val% -->';
//  <!-- %/foreach% -->
}

Argo_Calendar.holiday = [];

// クラスメソッド　init 自動実行
Argo_Calendar.init = function() {
};

Argo_Calendar.init();

// クラスメソッド
Argo_Calendar.get_opt = function () {
    return {
            dateFormat:'yy/mm/dd',
         
            changeYear: true,
            //numberOfMonths:[1,2], // 2か月表示
            showMonthAfterYear:true, // 年の後に月を表示させる
            beforeShowDay: function(dt) {
                // 祝日の判定
                var key;
                var y = dt.getFullYear();
                var m = dt.getMonth() + 1;
                var d = dt.getDate();
                key = y + '-';
                if (m < 10) {
                    key += '0' + m + '-';
                } else {
                    key += m + '-';
                }
                if (d < 10) {
                    key += '0' + d;
                } else {
                    key += d;
                }

                // 祝日
                if (Argo_Calendar.holiday[key] != undefined) {
                    return [true, 'date-holiday', Argo_Calendar.holiday[key]];
                }

                // 日曜日
                if (dt.getDay() == 0) {
                   return [true, 'date-sunday'];
                }
                // 土曜日
                if (dt.getDay() == 6) {
                    return [true, 'date-saturday'];
                }
                // 平日
                return [true, ''];
            }
            
    };
};



$(function() {
    var datepicker_opt = Argo_Calendar.get_opt();

    $.fn.set_Calendar = function () {
        this.each(function (index, element) {
            let dateFormat = $(element).attr('data-format');
            datepicker_opt.dateFormat = dateFormat;
            datepicker_opt.showButtonPanel = true;
            datepicker_opt.onClose = function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
            $(element).datepicker(datepicker_opt);
        })
    };
    // 初期値設定
    var calendar_plus = $('.datepicker-plus');
    if (calendar_plus.length > 0) {
        calendar_plus.set_Calendar();
    }

    $('.datepicker').datepicker(datepicker_opt);

});
