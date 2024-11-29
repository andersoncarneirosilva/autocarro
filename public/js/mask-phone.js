const handlePhone = (event) => {
  let input = event.target;
  input.value = phoneMask(input.value);
};

const phoneMask = (value) => {
  if (!value) return "";

  // Remover todos os caracteres não numéricos
  value = value.replace(/\D/g, '');

  // Limitar o número de dígitos para código de área (DDD), prefixo e número propriamente dito
  const ddd = value.slice(0, 2);
  const prefix = value.slice(2, 6);
  const number = value.slice(6, 11);

  // Aplicar a máscara
  if (ddd && prefix && number) {
      value = `(${ddd}) ${prefix}-${number}`;
  } else if (ddd && prefix) {
      value = `(${ddd}) ${prefix}`;
  } else if (ddd) {
      value = `(${ddd}`;
  }

  return value;
};
