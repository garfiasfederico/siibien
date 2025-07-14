-- Consulta para actualizar el campo parrafos_max en informe_acciones
-- con el total de elementos relacionados en ia_bs
UPDATE informe_acciones AS ia
SET parrafos_max = (
    SELECT COUNT(bs.idBS) + 1
    FROM ia_bs AS bs
    WHERE bs.ia_id = ia.id
);
