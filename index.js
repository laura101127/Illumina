document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("info-modal");
  const modalBody = document.getElementById("modal-body");
  const closeModalBtn = document.querySelector(".close-modal");

  // Datos detallados para mostrar en cada elemento interactivo
  const infoData = {
    heroCard: {
      titulo: "Recomendación del Día: Alimentación Equilibrada",
      contenido: "Una alimentación variada garantiza que obtengas todos los nutrientes necesarios sin aburrirte.<br><br><strong>Recomendaciones básicas:</strong><ul><li>Incluye al menos un alimento rico en fibra en cada comida.</li><li>Asegura una fuente de proteína limpia en tus platos principales.</li><li>Mantén una correcta hidratación consumiendo agua a lo largo del día.</li></ul>"
    },
    beneficios: [
      {
        titulo: "Conócete a fondo",
        contenido: "Comprender tus hábitos diarios es la clave del éxito.<br><br>En Illumina te guiamos para que analices tu nivel de energía, horas de descanso y preferencias culinarias, creando un mapa claro de tus necesidades reales."
      },
      {
        titulo: "Organízate sin estrés",
        contenido: "Simplifica tu semana planificando tus preparaciones con anticipación.<br><br>Te ayudamos a estructurar listas de compras eficientes y menús fáciles de cocinar para evitar improvisar comidas poco saludables."
      },
      {
        titulo: "Avanza a tu ritmo",
        contenido: "Lleva un registro amigable de tus progresos diarios.<br><br>Evalúa tus niveles de energía, digestión y constancia en lugar de enfocarte solo en conteos estrictos de calorías."
      }
    ],
    pasos: [
      {
        titulo: "Paso 1: Cuéntanos sobre ti",
        contenido: "Inicias completando un perfil dinámico donde nos indicas tus horarios, gustos, alimentos a evitar y objetivos específicos de salud o bienestar."
      },
      {
        titulo: "Paso 2: Encuentra un plan adaptado",
        contenido: "El sistema genera o te sugiere estructuras de alimentación ajustadas a tus necesidades, creadas con el apoyo de profesionales en nutrición."
      },
      {
        titulo: "Paso 3: Haz un seguimiento consciente",
        contenido: "Registra tus avances diariamente para identificar mejoras en tus hábitos y realizar pequeños ajustes sostenibles con el tiempo."
      }
    ],
    planes: [
      {
        titulo: "Plan Esencial (Gratis)",
        contenido: "Ideal para iniciar sin compromisos.<br><br><strong>Incluye:</strong> Recomendaciones generales, catálogo de recetas básicas, registro simple de hábitos diarios y artículos educativos sobre nutrición."
      },
      {
        titulo: "Plan Equilibrio ($19.900 / mes)",
        contenido: "Perfecto para organizar tu alimentación semanal de forma personalizada.<br><br><strong>Incluye:</strong> Todo lo del plan Esencial + Planificador semanal, recetas sugeridas por gustos, calendario de comidas y generador automático de listas de compras."
      },
      {
        titulo: "Plan Integral ($34.900 / mes)",
        contenido: "Acompañamiento avanzado para objetivos específicos de salud.<br><br><strong>Incluye:</strong> Todo lo del plan Equilibrio + Análisis detallado de nutrientes, acompañamiento personalizado y herramientas exclusivas para monitorear tu estilo de vida."
      }
    ],
    recetas: [
      {
        titulo: "Bowl de Vegetales y Proteína",
        contenido: "<strong>Ingredientes:</strong> Quinoa, garbanzos o pollo desmenuzado, espinacas frotadas, aguacate y aderezo de sésamo.<br><br><strong>Beneficios:</strong> Aporta carbohidratos complejos, proteína de alta calidad y grasas saludables que te mantienen satisfecho por más tiempo."
      },
      {
        titulo: "Ensalada Fresca",
        contenido: "<strong>Ingredientes:</strong> Hojas verdes mixtas, pepino, pepitas de calabaza, queso fresco y vinagreta cítrica.<br><br><strong>Beneficios:</strong> Fuente excelente de micronutrientes, fibra e hidratación ideal para acompañar tus almuerzos o cenas."
      },
      {
        titulo: "Desayuno Nutritivo",
        contenido: "<strong>Ingredientes:</strong> Avena reposada, frutos rojos, semillas de chía y mantequilla de maní o almendras.<br><br><strong>Beneficios:</strong> Rica en antioxidantes y fibra soluble para empezar el día con energía constante."
      }
    ]
  };

  // Función para abrir la ventana modal
  function openModal(title, content) {
    modalBody.innerHTML = `<h3>${title}</h3><div>${content}</div>`;
    modal.classList.add("show");
  }

  // Evento para cerrar modal con el botón X
  closeModalBtn.addEventListener("click", () => {
    modal.classList.remove("show");
  });

  // Evento para cerrar modal haciendo clic fuera de la caja
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("show");
    }
  });

  // Clic en la tarjeta Hero
  const heroCard = document.querySelector(".food-card");
  if (heroCard) {
    heroCard.addEventListener("click", () => {
      openModal(infoData.heroCard.titulo, infoData.heroCard.contenido);
    });
  }

  // Clics en Beneficios
  document.querySelectorAll(".beneficio").forEach((el, index) => {
    el.addEventListener("click", () => {
      const data = infoData.beneficios[index];
      if (data) openModal(data.titulo, data.contenido);
    });
  });

  // Clics en Pasos (Cómo Funciona)
  document.querySelectorAll(".step").forEach((el, index) => {
    el.addEventListener("click", () => {
      const data = infoData.pasos[index];
      if (data) openModal(data.titulo, data.contenido);
    });
  });

  // Clics en Planes (excluyendo el clic en el botón directo de registro)
  document.querySelectorAll(".plan").forEach((el, index) => {
    el.addEventListener("click", (e) => {
      if (e.target.tagName !== "A") {
        const data = infoData.planes[index];
        if (data) openModal(data.titulo, data.contenido);
      }
    });
  });

  // Clics en Recetas
  document.querySelectorAll(".recipe-card").forEach((el, index) => {
    el.addEventListener("click", () => {
      const data = infoData.recetas[index];
      if (data) openModal(data.titulo, data.contenido);
    });
  });
});