def file_get_contents(filename):
    with open(filename) as f:
        return f.read()

FACING          = 1
CONTENT         = file_get_contents('input')
INSTRUCTIONS    = CONTENT.split(', ')
POSITION        = {'Y': 0, 'X': 0}
VISITED         = {'0,0': 1}
HQPOS           = {}

def get_facing(x):
    return {
        5: 1,
        0: 4,
    }.get(x, x)

for INSTRUCTION in INSTRUCTIONS:
    TURN    = INSTRUCTION.strip()[:1]
    STEPS   = int(INSTRUCTION.strip()[1:])

    if TURN == 'R':
        FACING = get_facing(FACING+1)
    else:
        FACING = get_facing(FACING-1)

    if FACING in [3, 4]:
        STEPS = 0 - STEPS

    if FACING in [1, 3]:
        DIRECTION = 'Y'
    else:
        DIRECTION = 'X'

    for i in range(abs(STEPS)):
        WALK = -1 if (STEPS <= 0) else 1
        POSITION[DIRECTION] += WALK

        if HQPOS:
            continue

        KEY = ','.join([str(POSITION['X']), str(POSITION['Y'])])
        COUNT = int(VISITED.get(KEY, 0)) + 1

        VISITED[KEY] = COUNT

        if COUNT == 2:
            HQPOS.update(POSITION)

FIRST   = abs(POSITION['Y']) + abs(POSITION['X'])
SECOND  = abs(HQPOS['Y']) + abs(HQPOS['X'])

print "It is %d to the HQ but it is %d to the real HQ" % (FIRST, SECOND)

