var app = angular.module('myApp', ['angularUtils.directives.dirPagination','rzModule', 'ui.bootstrap','duScroll'])


.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest";
    $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
}])

.controller('appController',['$scope','$http','$document',function($scope, $http,$document){
  $scope.$on('LOAD', function(){$scope.loading =true});
  $scope.$on('UNLOAD', function(){$scope.loading =false});
  $scope.$on('HIDELATESTPRODUCT', function(){$scope.latestproduct = false;});
  $scope.latestproduct = true;


  $scope.contactUs = function($event){
    $scope.contactus = true;
    $event.preventDefault();
    var scrollToFooter = angular.element(document.getElementById('contact-form'));
    $document.scrollToElementAnimated(scrollToFooter);
  }


}])
.controller('newsletterController', function($scope, $http){
    $scope.$emit('LOAD');
    $scope.newsletter = {};

    $scope.subscribe = function($event){
      $event.preventDefault();

      $http.get("/newsletter/subscribe/"+$scope.newsletter.email).success(function(response) {
          $scope.newsletter = response;
          $scope.$emit('UNLOAD');
      });
    }
})
.controller('footerController', function($scope, $http){
  $scope.$emit('LOAD');
  $scope.footercategories = {};
  $scope.companydesc ={
    desc : "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?",
    limit : 250
    };

  $http.get('/product/list-category').success(function(response){
    $scope.footercategories = response;
    $scope.maxFootCategories = 5;
      $scope.$emit('UNLOAD');
  });
  $scope.message = {
    email: '',
    subject:'',
    content:'',
    alert_type:'',
    alert_message:'',
    action: ''
  }

  $scope.sentMessage = function($event){
    $event.preventDefault();
    $http({
      method  : 'POST',
      url     : '/contact/sending',
      data    : $.param($scope.message)
     })
      .success(function(response) {
      $scope.message = response;
      console.log(response);
    });
  }

})
.controller('departmentController',['$scope','$http','$document', function($scope, $http,$document){
  $scope.categories = {};
  $scope.brands = {};
  $scope.departments = {};
  $scope.departments.title = "";
  $scope.currentPage = "";
  $scope.pageSize = "";

  $scope.hideThis = true;
  $scope.$emit('LOAD');
  $http.get('/product/list-category').success(function(response){
      $scope.categories = response;
  }).then(
    $http.get('/product/list-brands').success(function(response){
      $scope.brands = response;
      $scope.maxbrands = 9;

    })
  ).then($scope.$emit('UNLOAD'));


  $scope.showByList = false;
  $scope.showByGrid = false;
  var scrollTo = angular.element(document.getElementById('department-area'));
  $scope.departmentCategoryAll = function(){
    $scope.showByList = true;
    $scope.showByGrid = false;
    $document.scrollToElementAnimated(scrollTo);
    $scope.title ="All Categories";
    $http.get('/product/department/allcategory').success(function(response){
      $scope.$emit('HIDELATESTPRODUCT');
      $scope.hideThis = false;
      $scope.currentPage = 1;
      $scope.pageSize = 10;
      $scope.departments = response;
    });
  }
  $scope.departmentCategory = function(context){
    $scope.showByList = true;
    $scope.showByGrid = false;
    $document.scrollToElementAnimated(scrollTo);
    $scope.title = context.category.category_title+"'s";
    $http({
      method  : 'POST',
      url     : '/product/department/category/',
      data    : $.param(context.category)
     })
      .success(function(response) {
        $scope.$emit('HIDELATESTPRODUCT');
        $scope.hideThis = false;
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.departments = response;

    });


  }
  $scope.departmentBrandAll = function(){
    $scope.showByList = true;
    $scope.showByGrid = false;
    $document.scrollToElementAnimated(scrollTo);
    $scope.title = "All Brands";
    $http.get('/product/department/allbrand').success(function(response){
      $scope.$emit('HIDELATESTPRODUCT');
      $scope.hideThis = false;
      $scope.currentPage = 1;
      $scope.pageSize = 10;
      $scope.departments = response;
    });

  }
  $scope.departmentBrand = function(context){
    $scope.showByList = true;
    $scope.showByGrid = false;
    $document.scrollToElementAnimated(scrollTo);
    $scope.title = context.brand.brand_title+"'s";
    $http({
      method  : 'POST',
      url     : '/product/department/brand/',
      data    : $.param(context.brand)
     })
      .success(function(response) {
        $scope.$emit('HIDELATESTPRODUCT');
        $scope.hideThis = false;
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.departments = response;

    });

  }

  $scope.changeToGrid = function(){
    $scope.showByList = false;
    $scope.showByGrid = true;
  }
  $scope.changeToList = function(){
    $scope.showByList = true;
    $scope.showByGrid = false;
  }

  $scope.select = function(item) {
    $scope.selected = item
  }
  $scope.isSelected = function(item) {
    return $scope.selected == item
  }

  $scope.pageChangeHandler = function(num) {
      console.log('meals page changed to ' + num);
  };
}])
.controller('PaginateDepartmentController', function($scope){

    $scope.pageChangeHandler = function(num) {
        console.log('going to page ' + num);
      };
})
.controller('mainMenuController',['$scope','$http','$document', function($scope, $http,$document){
  $scope.searchResults = {};
  $scope.currentPage2 = "";
  $scope.pageSize2 = "";
  // $scope.hideThis = true;
  $scope.hideThisSearch = true;
  var scrollTo = angular.element(document.getElementById('middle-header'));
  $scope.departmentSearch = function(query){

    if(query == ""){
      $scope.hideThisSearch = true;
    }else{
      $document.scrollToElementAnimated(scrollTo);
      $http.get('/product/department/all/'+query).success(function(response){
        $scope.hideThisSearch = false;
        $scope.currentPage = 1;
        $scope.pageSize2 = 10;
        $scope.searchResults = response;
      });
    }

  }
  $scope.pageChangeHandler2 = function(num) {
      console.log('meals page changed to ' + num);
  }

}])
.controller('PaginateSearchController', function($scope){

    $scope.pageChangeHandler2 = function(num) {
        console.log('going to page ' + num);
      };
})
.controller('searchformController', function($scope, $http){

  $scope.categories = {};
  $scope.brands = {};
  $scope.conditions = {};

  // $scope.search.priceRange = "0;10000";
  $http.get('/product/list-category').success(function(response){
        $scope.$emit('UNLOAD');
        $scope.categories = response;
  });
  $http.get('/product/list-brands').success(function(response){
      $scope.brands = response;
      $scope.$emit('UNLOAD');
  });
  $http.get('/product/list-conditions').success(function(response){
      $scope.conditions = response;
      $scope.$emit('UNLOAD');
  });

  $scope.search = {
    'brand': 0,
    'category': 0,
    'condition':0,
    'priceLow': 10,
    'priceHigh': 1000
  };
  $scope.sliderConfig = { min: 0, max: 10000, step: 2 };
  //


  $scope.searchProducts = function($event){
    $event.preventDefault();
    $scope.searchFormResults ={};
    console.log($scope.search);
    $http({
        url:"/product/search/all",
        method: "POST",
        data: $.param($scope.search)
    }).success(function(response){
        console.log(response);
    });
  }



})
.controller('productsController', function($scope, $http){
    $scope.products = {};
    $scope.$emit('LOAD');
    $scope.comparedid = {};

    $scope.default = true;
    $scope.list = false;
    $http.get('/product/list-all').success(function(response){
      function chunk(arr, size) {
        var products = [];
        for (var i=0; i<arr.length; i+=size) {
          products.push(arr.slice(i, i+size));

        }
        return products;

      }
      $scope.products = chunk(response, 3);

      console.log(response);
      $scope.$emit('UNLOAD');
    });
    // $http({
    //   method  : 'POST',
    //   url     : '/product/comparetable/',
    //   data    : $.param(  $scope.comparedid ) // pass in data as strings
    //  })
    //   .success(function(response) {
    //     console.log(response);
    //
    // })
    $scope.productByLists = {};
    $scope.changeToList = function(){
      $scope.default = false;
      $scope.list = true;
      $http.get('/product/list-all').success(function(response){
        $scope.productByLists  = response;
        console.log(response);
      });
    }
    $scope.changeToGrid = function(){
      $scope.default = true;
    }

});
app.controller('singleProductController',function($scope, $http){
  var product_id = angular.element( document.querySelector( '#_product_id' )).val();
  $scope.$emit('LOAD');
  $scope.products = {id: product_id};
  $scope.relateds = {};
  $scope.tops = {};

  $http.get('/product/related/'+$scope.products.id ).success(function(response){
    $scope.relateds = response;
    $scope.$emit('UNLOAD');
  });

  $http.get('/product/top/'+$scope.products.id ).success(function(response){
    $scope.tops = response;
    // console.log(response);
    $scope.$emit('UNLOAD');
  });

});
//filter....
app.controller('compareProductController',function($scope, $http){
    var product_id = angular.element( document.querySelector( '#_product_id' )).val();

    $scope.products = {id:product_id};
    $http.get('/product/relatedCompare/'+$scope.products.id).success(function(response){
      $scope.relateds = response;
      // console.log(response);
    });
})
.controller('favoriteController', function($scope, $http){
  $scope.favorites = {};
  $http.get('/favorite/list').success(function(response){
    function chunk(arr, size) {
      var favorites = [];
      for (var i=0; i<arr.length; i+=size) {
        favorites.push(arr.slice(i, i+size));
      }
      return favorites;
    }
    $scope.favorites = chunk(response, 3);
  });
})
.controller('productWidgetController', function($scope, $http){
  $scope.topVieweds = {};
  $scope.recentlyVieweds = {};
  $scope.newAddeds = {};

  $http.get('/products/topViewed').success(function(topviewed){
    $scope.topVieweds = topviewed;
  }).then(
    $http.get('/products/recentlyViewed').success(function(recentlyviewed){
      // $scope.recentlyVieweds = recentlyviewed;
    })
  ).then(
    $http.get('/products/newAdded').success(function(newadded){
      $scope.newAddeds = newadded;
      console.log(newadded);
    })
  );

});

app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
})
.filter('deleteprice', function () {
        return function (oldprice , newprice) {
          if(oldprice == 0 ){
            return '***';
          }else{
            if(oldprice > newprice ){
              return oldprice;
            }else{
              return '###';
            }
          }

        };
})
.filter('strlimit', function () {
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
// .filter('rangeFilter', function() {
//     return function( items, rangeInfo ) {
//         var filtered = [];
//         var min = parseInt(rangeInfo.userMin);
//         var max = parseInt(rangeInfo.userMax);
//         // If time is with the range
//         angular.forEach(items, function(item) {
//             if( item.time >= min && item.time <= max ) {
//                 filtered.push(item);
//             }
//         });
//         return filtered;
//     };
// });
app.directive('readMore', function() {
  return {
    restrict: 'A',
    transclude: true,
    replace: true,
    template: '<p></p>',
    scope: {
      string: '=',
      moreText: '@',
      lessText: '@',
      words: '@',
      ellipsis: '@',
      char: '@',
      limit: '@',
      content: '@'
    },
    link: function(scope, elem, attr, ctrl, transclude) {
      var moreText = angular.isUndefined(scope.moreText) ? ' <a class="read-more">see more...</a>' : ' <a class="read-more">' + scope.moreText + '</a>',
        lessText = angular.isUndefined(scope.lessText) ? ' <a class="read-less">hide</a>' : ' <a class="read-less">' + scope.lessText + '</a>',
        ellipsis = angular.isUndefined(scope.ellipsis) ? '' : scope.ellipsis,
        limit = angular.isUndefined(scope.limit) ?  120 : scope.limit;

      attr.$observe('content', function(str) {
        readmore(str);
      });

      transclude(scope.$parent, function(clone, scope) {
        readmore(clone.text().trim());
      });

      function readmore(text) {

        var text = text,
          orig = text,
          regex = /\s+/gi,
          charCount = text.length,
          wordCount = text.trim().replace(regex, ' ').split(' ').length,
          countBy = 'char',
          count = charCount,
          foundWords = [],
          markup = text,
          more = '';

        if (!angular.isUndefined(attr.words)) {
          countBy = 'words';
          count = wordCount;
        }

        if (countBy === 'words') { // Count words

          foundWords = text.split(/\s+/);

          if (foundWords.length > limit) {
            text = foundWords.slice(0, limit).join(' ') + ellipsis;
            more = foundWords.slice(limit, count).join(' ');
            markup = text + moreText + '<span class="more-text">' + more + lessText + '</span>';
          }

        } else { // Count characters

          if (count > limit) {
            text = orig.slice(0, limit) + ellipsis;
            more = orig.slice(limit, count);
            markup = text + moreText + '<span class="more-text">' + more + lessText + '</span>';
          }

        }

        elem.append(markup);
        elem.find('.read-more').on('click', function() {
          $(this).hide();
          elem.find('.more-text').addClass('show').slideDown();
        });
        elem.find('.read-less').on('click', function() {
          elem.find('.read-more').show();
          elem.find('.more-text').hide().removeClass('show');
        });

      }
    }
  };
})
.directive("striderslider", function() {
    return {
        restrict: 'A',
        scope: {
            config: "=config",
            low: "=low",
            high: "=high"
        },
        link: function(scope, elem, attrs) {
            var setModel = function(value) {
                scope.model = value;
            }

            $(elem).slider({
                range: true,
	            min: scope.config.min,
	            max: scope.config.max,
                step: scope.config.step,
                values: [scope.low, scope.high],
                slide: function(event, ui) {
                    scope.$apply(function() {
                        scope.price = ui.value;
                        scope.low = ui.values[0];
                        scope.high = ui.values[1];
                    });
                    $('#YourDiv').css('width', 100 - ui.values[1] +'%');
	            }
	        }).append('<div id="YourDiv" style="width: 10%"></div>');
    	}
    }
});
// .directive('scrollOnClick', function() {
//   return {
//     restrict: 'A',
//     link: function(scope, $elm) {
//       $elm.on('click', function() {
//         $(".maincontent-area").animate({scrollTop: $elm.offset().top}, "slow");
//       });
//     }
//   }
// });

// .factory('focus', function($timeout, $window) {
//     return function(id) {
//       // timeout makes sure that is invoked after any other event has been triggered.
//       // e.g. click events that need to run before the focus or
//       // inputs elements that are in a disabled state but are enabled when those events
//       // are triggered.
//       $timeout(function() {
//         var element = $window.document.getElementById(id);
//         if(element)
//           element.focus();
//       });
//     };
//   })
//
app.directive('eventFocus', function(focus) {
    return function(scope, elem, attr) {
      elem.on(attr.eventFocus, function() {
        focus(attr.eventFocusId);
      });

      // Removes bound events in the element itself
      // when the scope is destroyed
      scope.$on('$destroy', function() {
        element.off(attr.eventFocus);
      });
    };
  })
.directive('limitString', function () {
    return {
        scope: {
            string : '=' //Two-way data binding
        },
        template: '<ul><li>{{ string.limit }}</li></ul>'
    };
});
