-- Sincronizar los Datos de la tabla ia_alineacion 
--con informe acciones de la columna lineas con alineacion_la
UPDATE informe_acciones ia
JOIN ia_alineacion a
ON a.ia_id = ia.id
SET ia.alineacion_la = a.lineas;

-- Crear los triggers

DELIMITER $$

DROP TRIGGER IF EXISTS trg_ia_alineacion_ai $$
CREATE TRIGGER trg_ia_alineacion_ai
AFTER INSERT ON ia_alineacion
FOR EACH ROW
BEGIN
  UPDATE informe_acciones
    SET alineacion_la = NEW.lineas
  WHERE id = NEW.ia_id;
END $$

DROP TRIGGER IF EXISTS trg_ia_alineacion_au $$
CREATE TRIGGER trg_ia_alineacion_au
AFTER UPDATE ON ia_alineacion
FOR EACH ROW
BEGIN
  IF NOT (OLD.lineas <=> NEW.lineas) THEN
    UPDATE informe_acciones
      SET alineacion_la = NEW.lineas
    WHERE id = NEW.ia_id;
  END IF;
END $$

DELIMITER ;