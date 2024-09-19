$(".header-link").hover(function() { $(this).prepend("# "); }, function() { var text = $(this).text().replace(/# /g, ""); $(this).text(text); });
