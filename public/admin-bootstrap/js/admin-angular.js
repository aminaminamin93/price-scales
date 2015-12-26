
var app = angular.module('myApp', ['angularUtils.directives.dirPagination']);

// app.directive('loading', function () {
//       return {
//         restrict: 'E',
//         replace:true,
//         template: '<div class="alert alert-success">This is alert success</div>',
//         link: function (scope, element, attr) {
//               scope.$watch('loading', function (val) {
//                   if (val)
//                       $(element).show();
//                   else
//                       $(element).hide();
//               });
//         }
//       }
//   });
// <div class="cssload-wrap" ><div class="cssload-container"> <span class="cssload-dots"></span> <span class="cssload-dots"></span><span class="cssload-dots"></span> <span class="cssload-dots"></span><span class="cssload-dots"></span><span class="cssload-dots"></span><span class="cssload-dots"></span><span class="cssload-dots"></span><span class="cssload-dots"></span><span class="cssload-dots"></span></div></div>
app.controller('PdfCrawlerController', function($scope, $http) {

    $scope.$emit('LOAD');
    $http.get("/list-crawler-pdf")
    .success(function(response) {
      $scope.pdfs =  response;
       $scope.$emit('UNLOAD');
    });


    $scope.extractPdf = function($retailer){
      $scope.$emit('LOAD');
        $http.get("/crawler/start/pdf/"+$retailer.pdf_id+"/"+$retailer.r_name)
        .success(function(response) {
            var myEl = angular.element( document.querySelector( '.resultcrawlerpdf' ) );
            myEl.html(response);

            setTimeout(function(){
              var myEl = angular.element( document.querySelector( '.resultcrawlerpdf' ) );
              myEl.html("");
            }, 4000);
            $scope.$emit('UNLOAD');

        });

    }

    $scope.processdata = function($retailername){

      $scope.$emit('LOAD');
      $http.get("/crawler/processdata/pdf/"+$retailername.r_name)
      .success(function(response) {
          var myEl = angular.element( document.querySelector( '.resultcrawlerpdf' ) );
          myEl.html(response);

          setTimeout(function(){
            var myEl = angular.element( document.querySelector( '.resultcrawlerpdf' ) );
            myEl.html("");
          }, 4000);
          $scope.$emit('UNLOAD');
      });


    }

});

app.controller('WebsiteCrawlerController', function($scope, $http){
  $scope.$emit('LOAD');
  $http.get("/list-crawler-website")
  .success(function(response) {
    $scope.webcrawlers = response;
    $scope.$emit('UNLOAD');
  });


  $scope.startCrawlerWebsite = function($crawlername){


      $scope.$emit('LOAD');
      $http.get("/crawler/startcrawler/website/"+$crawlername.crawler_name)
      .success(function(response) {

          var myEl = angular.element( document.querySelector( '.resultcrawlerwebsite' ) );
          myEl.html(response);

          setTimeout(function(){
            var myEl = angular.element( document.querySelector( '.resultcrawlerwebsite' ) );
            myEl.html("");
          }, 4000);

          $scope.$emit('UNLOAD');
      });
    }

});

app.controller('GeneralSettingsController', function($scope, $http){
  $scope.$emit('LOAD');
  $http.get("/settings-general")
  .success(function(response) {
    $scope.generalsettings =  response;
    $scope.$emit('UNLOAD');
  });
});


app.controller('SystemlogsController', function($scope, $http){
  $scope.pageSize = 10;
  $scope.$emit('LOAD');
  $http.get("/system-logs")
  .success(function(response) {
    $scope.systemlogs = response;
    // console.log(response);
    $scope.$emit('UNLOAD');
  });

  $scope.pageChangeHandler = function(num) {
      console.log('meals page changed to ' + num);
  };
});

app.controller('SystemlogsController2', function($scope, $http){
  $scope.pageChangeHandler = function(num) {
    console.log('going to page ' + num);
  };
});

app.controller('mailListController', function($scope, $http){
  $scope.$emit('LOAD');

  $scope.total_mailboxs = 0;
  $http.get("/total-mailbox")
  .success(function(response) {
      $scope.total_mailboxs = response;
  }).then(function(){
    $http.get("/list-mailbox?view="+$scope.mailLimit)
    .success(function(response) {
      $scope.mailTotal = response;
      $scope.mailLists = response;


      $scope.$emit('UNLOAD');
    });
  });


  $scope.mailLimit = 0;
  $scope.disableLeftRange = disableLeftRange($scope);
  $scope.mailListLimit = function(rowNumber){

      $scope.$emit('LOAD');
      $scope.mailLimit = $scope.mailLimit + rowNumber;
      $scope.disableLeftRange = disableLeftRange($scope);

      $http.get("/list-mailbox?view="+$scope.mailLimit)
      .success(function(response) {
        $scope.mailTotal = response;
        $scope.mailRow = rowNumber;
        $scope.mailLists = response;
        $scope.$emit('UNLOAD');
        $scope.disableRightRange = disableRightRange($scope);
      });

  }


});

function disableLeftRange($scope){
  if($scope.mailLimit < 1){
    return true;
  }else{
    return false;
  }
}
function disableRightRange($scope){
  if($scope.mailTotal.length < $scope.mailRow){
    return true;
  }else{
    return false;
  }
}

app.controller('appController', function($scope){
  $scope.$on('LOAD', function(){$scope.loading =true});
  $scope.$on('UNLOAD', function(){$scope.loading =false});

});

app.filter('strlimit', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                    value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
});


app.filter('timeago', function() {
     return function(input, p_allowFuture) {
         var substitute = function (stringOrFunction, number, strings) {
                 var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, dateDifference) : stringOrFunction;
                 var value = (strings.numbers && strings.numbers[number]) || number;
                 return string.replace(/%d/i, value);
             },
             nowTime = (new Date()).getTime(),
             date = (new Date(input)).getTime(),
             //refreshMillis= 6e4, //A minute
             allowFuture = p_allowFuture || false,
             strings= {
                 prefixAgo: null,
                 prefixFromNow: null,
                 suffixAgo: "ago",
                 suffixFromNow: "from now",
                 seconds: "less than a minute",
                 minute: "about a minute",
                 minutes: "%d minutes",
                 hour: "about an hour",
                 hours: "about %d hours",
                 day: "a day",
                 days: "%d days",
                 month: "about a month",
                 months: "%d months",
                 year: "about a year",
                 years: "%d years"
             },
             dateDifference = nowTime - date,
             words,
             seconds = Math.abs(dateDifference) / 1000,
             minutes = seconds / 60,
             hours = minutes / 60,
             days = hours / 24,
             years = days / 365,
             separator = strings.wordSeparator === undefined ?  " " : strings.wordSeparator,

             // var strings = this.settings.strings;
             prefix = strings.prefixAgo,
             suffix = strings.suffixAgo;

         if (allowFuture) {
             if (dateDifference < 0) {
                 prefix = strings.prefixFromNow;
                 suffix = strings.suffixFromNow;
             }
         }

         words = seconds < 45 && substitute(strings.seconds, Math.round(seconds), strings) ||
         seconds < 90 && substitute(strings.minute, 1, strings) ||
         minutes < 45 && substitute(strings.minutes, Math.round(minutes), strings) ||
         minutes < 90 && substitute(strings.hour, 1, strings) ||
         hours < 24 && substitute(strings.hours, Math.round(hours), strings) ||
         hours < 42 && substitute(strings.day, 1, strings) ||
         days < 30 && substitute(strings.days, Math.round(days), strings) ||
         days < 45 && substitute(strings.month, 1, strings) ||
         days < 365 && substitute(strings.months, Math.round(days / 30), strings) ||
         years < 1.5 && substitute(strings.year, 1, strings) ||
         substitute(strings.years, Math.round(years), strings);

         return $.trim([prefix, words, suffix].join(separator));
         // conditional based on optional argument
         // if (somethingElse) {
         //     out = out.toUpperCase();
         // }
         // return out;
     }
});
