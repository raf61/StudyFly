import DomPurify from "dompurify";
import {marked} from 'marked'
function escapeHtml(unsafe)
{
    return unsafe
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    //.replace(/&/g, "&amp;")
    //.replace(/"/g, "&quot;")
    //.replace(/'/g, "&#39;");
 }


export default function markdown(md){
    const renderer = new marked.Renderer();

    function mathsExpression(expr) {
        return `<img src="https://latex.codecogs.com/gif.latex?${expr}" />`
      }
      
      const rendererCode = renderer.code;
      renderer.code = function(code, lang, escaped) {
        if (!lang) {
          const math = mathsExpression(code);
          if (math) {
            return math;
          }
        }
      
        return rendererCode(code, lang, escaped);
      };
      
      const rendererCodespan = renderer.codespan;
      renderer.codespan = function(text) {
        const math = mathsExpression(text);
        if (math) {
          return math;
        }
      
        return rendererCodespan(text);
      };
    let parsed = marked(escapeHtml(md), { renderer })
    return DomPurify.sanitize(parsed)
}