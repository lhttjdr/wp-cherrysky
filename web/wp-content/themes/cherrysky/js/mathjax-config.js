// MathJax
window.MathJax = {
  messageStyle: "none",
  showProcessingMessages: false,
  jax: ["input/TeX", "output/SVG"],
  CommonHTML: {
    linebreaks: {
      automatic: true
    },
    mtextFontInherit: true
  },
  SVG: {
    linebreaks: {
      automatic: true
    },
    mtextFontInherit: true
  },
  "HTML-CSS": {
    linebreaks: {
      automatic: true
    },
    mtextFontInherit: true
  },
  PreviewHTML: {
    linebreaks: {
      automatic: true
    },
    mtextFontInherit: true
  },
  extensions: ["tex2jax.js", "asciimath2jax.js", "mml2jax.js", "MathMenu.js", "MathZoom.js"],
  TeX: {
    extensions: ["AMSmath.js", "AMSsymbols.js", "autoload-all.js"]
  },
  styles: {
    ".MathJax_SVG svg": {
      "color": "inherit !important",
    },
  },
  tex2jax: {
    inlineMath: [
      ['$', '$'],
      ["\\(", "\\)"]
    ],
    processEscapes: true,
    // preview: 'none'
  },
  // https://codepen.io/pkra/pen/EPeKjo,  Peter Krautzberger
  AuthorInit: function() {
    MathJax.Hub.Register.MessageHook("End Process", function(message) {
      let timeout = false, // holder for timeout id
        delay = 250; // delay after event is "complete" to run callback
      let reflowMath = function() {
        let dispFormulas = document.getElementsByClassName("formula");
        if (dispFormulas) {
          for (let i = 0; i < dispFormulas.length; i++) {
            let dispFormula = dispFormulas[i];
            let child = dispFormula.getElementsByClassName("MathJax_Preview")[0].nextSibling.firstChild;
            let isMultiline = MathJax.Hub.getAllJax(dispFormula)[0].root.isMultiline;
            if (dispFormula.offsetWidth < child.offsetWidth || isMultiline) {
              MathJax.Hub.Queue(["Rerender", MathJax.Hub, dispFormula]);
            }
          }
        }
      };
      window.addEventListener('resize', function() {
        // clear the timeout
        clearTimeout(timeout);
        // start timing for event "completion"
        timeout = setTimeout(reflowMath, delay);
      });
    });
  }
};