(function($, window) {
  $(document).ready(function() {
	 function unescapeHtml(safe) {
    return safe.replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#039;/g, "'");
    }

    let simpleHighlight = function(text) {
      let sections = unescapeHtml(text).split("\n\n");
      for (let t = 0; t < sections.length; t++) {
        let lines = sections[t].split("\n");
        let prompt = /^([0-9a-z_/\\\.~\-@\s]*)\s*(#|\$|>|❯)/i;
        for (let i = 0; i < lines.length; i++) {
          let matchs = lines[i].match(prompt);
          if (matchs) {
            let line = "<span class=\"" + (matchs[2] === "#" ? "root-" : "") + "prompt\">" + matchs[0] + "</span>";
            let cmd = lines[i].substr(matchs[0].length);
            let parts = cmd.split(" ");
            let j = 0;
            while (j < parts.length && parts[j] == "") j++;
            if (j < parts.length) {
              if (["sudo", "git", "npm"].includes(parts[j])) {
                parts[j] = "<span class=\"command\">" + parts[j] + "</span>";
                let k = j + 1;
                while (k < parts.length && parts[k] == "") j++;
                if (k < parts.length) {
                  parts[k] = "<span class=\"command\">" + parts[k] + "</span>";
                }
              } else {
                parts[j] = "<span class=\"command\">" + parts[j] + "</span>";
              }
            }
            lines[i] = line + parts.join(" ");
          }
        }
        sections[t] = "<p>" + lines.join("<br/>") + "</p>";
      }
      return sections.join("\n");
    }

    $('.osx').each(function(i, code) {
      // let cmd = createWindow($(code).attr("title"), $(code).html());
      let conzole = $.parseHTML('<div class="osx-window">' +
        '<div class="osx-toolbar">' +
        '		<div class="osx-top">' +
        '			  <div class="osx-lights">' +
        '				<div class="osx-light osx-red">' +
        '					<div class="osx-glyph">×</div>' +
        '					<div class="osx-shine"></div>' +
        '					<div class="osx-glow"></div>' +
        '				</div>' +
        '				<div class="osx-light osx-yellow">' +
        '					<div class="osx-glyph">-</div>' +
        '					<div class="osx-shine"></div>' +
        '					<div class="osx-glow"></div>' +
        '				</div>' +
        '				<div class="osx-light osx-green">' +
        '					<div class="osx-glyph">+</div>' +
        '					<div class="osx-shine"></div>' +
        '					<div class="osx-glow"></div>' +
        '				</div>' +
        '			</div>' +
        '			<div class="osx-title">' +
        '				<div class="osx-folder">' +
        '					<div class="osx-folder-tab"></div>' +
        '					<div class="osx-folder-body"></div>' +
        '				</div>' +
        $(code).attr("title") +
        '			</div>' +
        '			<div class="osx-bubble">' +
        '				<div class="osx-shine"></div>' +
        '				<div class="osx-glow"></div>' +
        '			</div>' +
        '		</div>' +
        '	</div>' +
        '	<div class="osx-body">' +
        simpleHighlight($(code).html()) +
        '	</div>' +
        '</div>');
      code.replaceWith(conzole[0]);
    });
  });
})(jQuery, window);