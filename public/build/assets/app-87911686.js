document.addEventListener("DOMContentLoaded",function(){console.log("Iniciando escuta no canal 'app.js'..."),console.log("authUserId:",window.authUserId);const o=document.getElementById("message-list");o&&window.authUserId?(window.Echo.leave("chat."+window.authUserId),window.Echo.channel("chat."+window.authUserId).listen("NewMessage",e=>{try{if(console.log("Nova mensagem recebida:",e),!e.id||!e.content||!e.sender_id||!e.created_at){console.error("Dados de mensagem inválidos:",e);return}const s=document.createElement("li"),a=e.sender_id===window.authUserId?"user-message":"admin-message";s.classList.add(a);const n=new Date(e.created_at).toLocaleTimeString([],{hour:"2-digit",minute:"2-digit"});s.innerHTML=`
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <p>${e.content}</p>
                            </div>
                            <span class="message-time">${n}</span>
                        </div>
                    `,o.appendChild(s),o.scrollTop=o.scrollHeight}catch(s){console.error("Erro ao processar a mensagem:",s)}})):console.warn("Elemento #message-list não encontrado ou authUserId não definido.")});
