"use strict";!function(){var e=$(window);$(".article_slider").slick({arrows:!0,dots:!0,asNavFor:".article_slider_description"}),$(".article_slider_description").slick({arrows:!1,dots:!1,asNavFor:".article_slider",fade:!0}),e.load(function(){equalheight(".team_list .team_item")}),e.resize(function(){equalheight(".team_list .team_item")}),$(".read_more").on("click",function(e){e.preventDefault();var i=$(this).prev().find(".t_info_inner").height();$(this).hasClass("open")&&(i=75),$(this).toggleClass("open"),$(this).prev().animate({height:i+"px"})})}();
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInd3LmpzIl0sIm5hbWVzIjpbIiR3aW5kb3ciLCIkIiwid2luZG93Iiwic2xpY2siLCJkb3RzIiwiYXJyb3dzIiwibG9hZCIsImVxdWFsaGVpZ2h0IiwicmVzaXplIiwiJHJlYWRNb3JlIiwiZSIsInByZXZlbnREZWZhdWx0IiwidGhpcyIsInByZXYiLCJmaW5kIiwiaGVpZ2h0IiwiJGhlaWdodCIsImhhc0NsYXNzIiwidG9nZ2xlQ2xhc3MiXSwibWFwcGluZ3MiOiJjQUFBLFdBQ0ksR0FBSUEsR0FBVUMsRUFBRUMsT0FEbkJELEdBQUEsbUJBQVlFLE9BQ0xILFFBQUFBLEVBQ0xJLE1BQUEsRUFDS0MsU0FBUSxnQ0FEWUosRUFBM0IsK0JBQUFFLE9BT09FLFFBQVEsRUFEVkQsTUFBQSxFQUNFQyxTQUFRLGtCQUNSRCxNQUFNLElBRjZCSixFQUF2Q00sS0FBQSxXQVFFQyxZQUFZLDJCQUlkUCxFQUFRUSxPQUFPLFdBQWZSLFlBQUEsMkJBSWdCQyxFQUFFLGNBQWRRLEdBQUFBLFFBQWMsU0FBbEJDLEdBQ0FELEVBQUFBLGdCQUNJQyxJQUFFQyxHQUFBQSxFQUFGQyxNQUFBQyxPQUFBQyxLQUFBLGlCQUFBQyxRQUNBZCxHQUFJZSxNQUFBQSxTQUFVLFVBQ1hmLEVBQVFnQixJQUVWaEIsRUFBQVcsTUFBQU0sWUFBQSxRQUNEakIsRUFBRVcsTUFBTU0sT0FBQUEsU0FDTkgsT0FBRkMsRUFBdUIiLCJmaWxlIjoid3cuanMiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gKCkge1xuICAgIHZhciAkd2luZG93ID0gJCh3aW5kb3cpO1xuXHQkKCcuYXJ0aWNsZV9zbGlkZXInKS5zbGljayh7XG4gICAgICAgIGFycm93czogdHJ1ZSxcbiAgICAgICAgZG90czogdHJ1ZSxcbiAgICAgICAgYXNOYXZGb3I6ICcuYXJ0aWNsZV9zbGlkZXJfZGVzY3JpcHRpb24nXG4gICAgfSk7XG5cbiAgICAkKCcuYXJ0aWNsZV9zbGlkZXJfZGVzY3JpcHRpb24nKS5zbGljayh7XG4gICAgICAgIGFycm93czogZmFsc2UsXG4gICAgICAgIGRvdHM6IGZhbHNlLFxuICAgICAgICBhc05hdkZvcjogJy5hcnRpY2xlX3NsaWRlcicsXG4gICAgICAgIGZhZGU6IHRydWVcbiAgICB9KTtcblxuICAgICR3aW5kb3cubG9hZChmdW5jdGlvbigpIHtcbiAgICAgIGVxdWFsaGVpZ2h0KCcudGVhbV9saXN0IC50ZWFtX2l0ZW0nKTtcbiAgICB9KTtcblxuXG4gICAgJHdpbmRvdy5yZXNpemUoZnVuY3Rpb24oKXtcbiAgICAgIGVxdWFsaGVpZ2h0KCcudGVhbV9saXN0IC50ZWFtX2l0ZW0nKTtcbiAgICB9KTtcblxuICAgIHZhciAkcmVhZE1vcmUgPSAkKCcucmVhZF9tb3JlJyk7XG4gICAgJHJlYWRNb3JlLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyICRoZWlnaHQgPSAkKHRoaXMpLnByZXYoKS5maW5kKCcudF9pbmZvX2lubmVyJykuaGVpZ2h0KCk7XG4gICAgICAgIGlmKCQodGhpcykuaGFzQ2xhc3MoJ29wZW4nKSl7XG4gICAgICAgICAgICAkaGVpZ2h0ID0gNzU7XG4gICAgICAgIH1cbiAgICAgICAgJCh0aGlzKS50b2dnbGVDbGFzcygnb3BlbicpO1xuICAgICAgICAkKHRoaXMpLnByZXYoKS5hbmltYXRlKHtcbiAgICAgICAgICAgICdoZWlnaHQnOiAkaGVpZ2h0ICsgJ3B4J1xuICAgICAgICB9KVxuICAgIH0pO1xuXG59KSgpOyJdfQ==