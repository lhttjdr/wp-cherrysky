(function($, window) {
  $(document).ready(function() {
    // cookie
    let host = location.hostname.split('.');
    let path = location.pathname.split('/');
    let lang = 'en-us';
    switch (host[0]) {
      case "ja":
        lang = 'ja';
        break;
      case "eo":
        lang = "eo";
        break;
      case "es":
        lang = "es-es";
        break;
      case "en":
        lang = "en-us";
        break;
      case "zh":
        if (path.length > 0 && path[0] == "zh-hant") {
          lang = "zh-hant-cn";
        } else {
          lang = "zh-hans-cn";
        }
        break;
      default:
        lang = "en-us";
    }
    let expires = new Date();
    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
    document.cookie = 'USER_LANGUAGE=' + lang + ';path=/;domain=' + host + ';expires=' + expires.toUTCString();

    // highlight.js
    if (typeof hljs != 'undefined') {
      hljs.configure({
        tabReplace: '    ', // 4 spaces
        classPrefix: 'hljs-'
        // … other options aren't changed
      })
      $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
      });
      $('code.hljs').each(function(i, block) {
        hljs.lineNumbersBlock(block);
      });
    }

    // pseudocode.js
    // It does not parse latex code and it must be excuted before MathJax rendering.
    if (typeof pseudocode != 'undefined' && typeof MathJax != 'undefined') {
      $('pre.pseudocode').each(function(i, code) {
        let div = document.createElement("div");
        pseudocode.render(code.textContent, div, {
          lineNumber: true,
          noEnd: false
        });
        code.parentNode.replaceChild(div, code);
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, div]);
      });
    }

    // mermaid
    if (typeof mermaidAPI != 'undefined') {
      mermaidAPI.initialize({
        startOnLoad: false,
      });
      $('.mermaid').each(function(i, code) {
        let id = 'mermaid' + i;
        let insertSvg = function(svgCode, bindFunctions) {
          code.innerHTML = svgCode;
          if (typeof callback !== 'undefined') {
            callback(id);
          }
          bindFunctions(code);
        };
        mermaidAPI.render(id, code.textContent, insertSvg);
      });
    }
    // tocbot
    let titles = $('.post-content h2:not(.noindex), .post-content h3:not(.noindex), .post-content h4:not(.noindex)');
    if (titles.length > 0) {
      tocbot.init({
        // Where to render the table of contents.
        tocSelector: '.toc',
        // Where to grab the headings to build the table of contents.
        contentSelector: '.post-content',
        // Which headings to grab inside of the contentSelector element.
        headingSelector: 'h2, h3, h4',
        // Headings that match the ignoreSelector will be skipped.
        ignoreSelector: '.noindex',
      });
    } else {
      $('.toc_widget').hide();
    }

    $('.plotly, .vis').each(function(i, node) {
      let div = document.createElement("div");
      div.id = node.id;
      let script = document.createElement("script");
      script.textContent = node.textContent;
      script.type = "text/javascript";
      node.parentNode.replaceChild(div, node);
      div.parentNode.appendChild(script);
    });

    $('.graphviz').each(function(i, node) {
      let div = document.createElement("div");
      div.innerHTML = Viz(node.textContent);
      node.parentNode.replaceChild(div, node);
    });

    // go to top
    jQuery(window).scroll(function() {
      //最上部から現在位置までの距離を取得して、変数[now]に格納
      var now = jQuery(window).scrollTop();
      //最上部から現在位置までの距離(now)が600以上
      if (now > 600) {
        //[#page-top]をゆっくりフェードインする
        jQuery('#page-top').fadeIn('slow');
        //それ以外だったらフェードアウトする
      } else {
        jQuery('#page-top').fadeOut('slow');
      }
    });
    //ボタン(id:move-page-top)のクリックイベント
    jQuery('#move-page-top').click(function() {
      //ページトップへ移動する
      jQuery('body,html').animate({
        scrollTop: 0
      }, 800);
    });
  });
})(jQuery, window);